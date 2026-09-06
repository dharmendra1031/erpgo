<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ProtectSensitiveRoutes
{
    /**
     * Legacy ERPGo contains a number of internal routes without route-level
     * authentication. Keep intentionally public invoice/form/career callbacks
     * untouched and centrally require authentication for known internal paths.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->isSensitiveInternalRequest($request)) {
            return $next($request);
        }

        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->guest(route('login'));
        }

        if ($request->is('user-reset-password/*')) {
            $this->authorizeUserPasswordReset($request);
        }

        if ($request->is('client-reset-password/*')) {
            $this->authorizeClientPasswordReset($request);
        }

        return $next($request);
    }

    private function isSensitiveInternalRequest(Request $request)
    {
        $patterns = [
            'user-reset-password/*',
            'client-reset-password/*',
            'change-password',
            'change/mode',
            'productservice/index',
            'invoices/template/setting',
            'bill/template/setting',
            'proposal/template/setting',
            'deals/user',
            'search',
            'stages',
            'stages/*',
            'pipelines',
            'pipelines/*',
            'labels',
            'labels/*',
            'sources',
            'sources/*',
            'payments',
            'payments/*',
            'custom_fields',
            'custom_fields/*',
            'lead_stages/order',
            'leads/json',
            '*/notification/seen',
            'projects/*/comment/*',
            'projects/*/checklist/*',
            'projects/*/change/*',
            'calendar/*/drag',
            'project-task-stages/order',
            'plan/paystack/*',
            'plan/flaterwave/*',
            'plan/razorpay/*',
            'plan/mercado/*',
            'plan/mollie/*',
            'plan/skrill/*',
            'plan/coingate/*',
        ];

        foreach ($patterns as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }

        return false;
    }

    private function authorizeUserPasswordReset(Request $request)
    {
        $actor = Auth::user();
        if ($actor->type !== 'super admin' && !$actor->can('edit user')) {
            abort(403, 'Permission denied.');
        }

        $target = $this->resolveTargetUser($request->route('id'));
        if (!$target || $target->type === 'client') {
            abort(404);
        }

        if ($actor->type !== 'super admin' && (int) $target->created_by !== (int) $actor->creatorId()) {
            abort(403, 'Permission denied.');
        }
    }

    private function authorizeClientPasswordReset(Request $request)
    {
        $actor = Auth::user();
        if (!$actor->can('edit client')) {
            abort(403, 'Permission denied.');
        }

        $target = $this->resolveTargetUser($request->route('id'));
        if (!$target || $target->type !== 'client') {
            abort(404);
        }

        if ((int) $target->created_by !== (int) $actor->creatorId()) {
            abort(403, 'Permission denied.');
        }
    }

    private function resolveTargetUser($routeId)
    {
        if ($routeId === null || $routeId === '') {
            return null;
        }

        $targetId = $routeId;
        if (!ctype_digit((string) $routeId)) {
            try {
                $targetId = Crypt::decrypt($routeId);
            } catch (\Exception $e) {
                return null;
            }
        }

        return User::find($targetId);
    }
}
