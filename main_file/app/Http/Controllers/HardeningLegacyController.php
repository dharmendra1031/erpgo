<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class HardeningLegacyController extends Controller
{
    public function filterUserView(Request $request)
    {
        $authUser = Auth::user();
        abort_unless($authUser->can('manage user'), 403);

        if ($authUser->type === 'super admin') {
            $query = User::where('created_by', $authUser->creatorId())
                ->where('type', 'company');
        } else {
            $query = User::where('created_by', $authUser->creatorId())
                ->where('type', '!=', 'client');
        }

        if ($request->status === 'active') {
            $query->where('is_active', 1);
        } elseif ($request->status === 'disable') {
            $query->where('is_active', 0);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', $keyword . '%')
                    ->orWhere('email', 'like', $keyword . '%');
            });
        }

        $users = $query->get(['id', 'name', 'email', 'type', 'is_active', 'delete_status']);

        $html = '';
        foreach ($users as $user) {
            $html .= '<div class="col-lg-3 col-sm-6 col-md-6">'
                . '<div class="card profile-card p-3">'
                . '<h4 class="h4 mb-1">' . e($user->name) . '</h4>'
                . '<span class="badge badge-pill badge-blue">' . e(ucfirst($user->type)) . '</span>'
                . '<div class="text-sm mt-2">' . e($user->email) . '</div>'
                . '</div></div>';
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'users' => $users,
        ]);
    }

    public function checkUserExists(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'email' => 'nullable|email',
            'id' => 'nullable|integer',
            'role' => 'nullable|string|max:50',
        ]);

        $projectId = (int) $request->project_id;
        abort_unless(in_array($projectId, $this->accessibleProjectIds(), true), 403);

        $authUser = Auth::user();
        $query = User::where(function ($q) use ($authUser) {
            $q->where('created_by', $authUser->creatorId())
                ->orWhere('id', $authUser->creatorId());
        });

        if ($request->filled('email')) {
            $query->where('email', $request->email);
        } elseif ($request->filled('id')) {
            $query->where('id', $request->id);
        } else {
            return response()->json([
                'code' => 422,
                'status' => 'Error',
                'error' => __('Email or user id is required.'),
            ], 422);
        }

        $user = $query->first();
        if (!$user) {
            return response()->json([
                'code' => 404,
                'status' => 'Error',
                'exists' => false,
                'error' => __('This user is not available in your company.'),
            ], 404);
        }

        $alreadyInvited = ProjectUser::where('project_id', $projectId)
            ->where('user_id', $user->id)
            ->exists();

        return response()->json([
            'code' => $alreadyInvited ? 202 : 200,
            'status' => 'Success',
            'exists' => true,
            'already_invited' => $alreadyInvited,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'success' => $alreadyInvited
                ? __('This User is already invited.')
                : __('User is available to invite.'),
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'nullable|string|max:120',
        ]);

        $projectIds = $this->accessibleProjectIds();
        $tasks = ProjectTask::with('project')->whereIn('project_id', $projectIds);

        if ($request->filled('keyword')) {
            $tasks->where('name', 'like', $request->keyword . '%');
        } else {
            $tasks->orderBy('end_date', 'desc')->limit(5);
        }

        $tasks = $tasks->limit(20)->get();
        $html = '';

        foreach ($tasks as $task) {
            if (!$task->project) {
                continue;
            }

            $html .= '<li><a class="list-link" href="'
                . e(route('projects.tasks.index', $task->project_id))
                . '"><i class="fas fa-search"></i><span>'
                . e($task->name)
                . '</span> ' . e(__('in '))
                . e($task->project->project_name)
                . '</a></li>';
        }

        if ($html === '') {
            $html = '<li><a class="list-link" href="#"><i class="fas fa-search"></i><span>'
                . e(__('No Tasks Found'))
                . '</span></a></li>';
        }

        return response($html, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function expenseList(Request $request)
    {
        abort_unless(Auth::user()->can('manage expense'), 403);

        $request->validate([
            'project' => 'nullable|integer',
        ]);

        $projectIds = $this->accessibleProjectIds();
        $query = Expense::whereIn('project_id', $projectIds);

        if ($request->filled('project') && (int) $request->project !== 0) {
            $projectId = (int) $request->project;
            abort_unless(in_array($projectId, $projectIds, true), 403);
            $query->where('project_id', $projectId);
        }

        $expenses = $query->latest()->get();
        $total = $expenses->count();

        return view('expenses.list', compact('expenses', 'total'));
    }

    public function notificationSeen($uid)
    {
        $user = Auth::user();

        if (Schema::hasTable('notifications')) {
            $notification = $user->notifications()->where('id', $uid)->first();

            if ($notification) {
                $notification->markAsRead();
            } elseif ((string) $uid === (string) $user->id) {
                $user->unreadNotifications->markAsRead();
            }
        }

        return redirect()->back();
    }

    private function accessibleProjectIds()
    {
        $user = Auth::user();

        if ($user->type === 'super admin') {
            return [];
        }

        $ids = Project::where('created_by', $user->id)->pluck('id');

        if ($user->type === 'company') {
            $ids = $ids->merge(Project::where('created_by', $user->creatorId())->pluck('id'));
        } else {
            $ids = $ids->merge(
                ProjectUser::where('user_id', $user->id)->pluck('project_id')
            );
        }

        return $ids->map(function ($id) {
            return (int) $id;
        })->unique()->values()->all();
    }
}
