<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ProtectLegacyStaffRoutes
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }

        $path = trim($request->path(), '/');

        $exact = [
            'change-password',
            'change/mode',
            'productservice/index',
        ];

        $prefixes = [
            'user-reset-password/',
            'import/',
            'export/',
            'tracker/',
        ];

        $protected = in_array($path, $exact, true);

        if (!$protected) {
            foreach ($prefixes as $prefix) {
                if (strpos($path, $prefix) === 0) {
                    $protected = true;
                    break;
                }
            }
        }

        if ($protected) {
            return redirect()->guest(route('login'));
        }

        return $next($request);
    }
}
