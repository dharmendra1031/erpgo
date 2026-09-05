<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\ProjectUser;
use App\Models\TimeTracker;
use App\Models\TrackPhoto;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    use \App\Traits\ApiResponser;

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }

        $user = auth()->user();

        if ((isset($user->delete_status) && (int) $user->delete_status === 0)
            || (isset($user->is_active) && (int) $user->is_active === 0)) {
            Auth::logout();
            return $this->error('Account is inactive', 403);
        }

        $settings = Utility::settings($user->id);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken,
            'user' => $user,
            'settings' => [
                'shot_time' => isset($settings['interval_time']) ? $settings['interval_time'] : 0.5,
            ],
        ], 'Login successfully.');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->success([], 'Tokens Revoked');
    }

    public function getProjects(Request $request)
    {
        $user = auth()->user();

        if ($user->isUser()) {
            $assignProjectIds = ProjectUser::where('user_id', $user->id)->pluck('project_id');

            $projects = Project::with('tasks')
                ->select(['project_name', 'id', 'client_id'])
                ->whereIn('id', $assignProjectIds)
                ->get()
                ->toArray();
        } else {
            $projects = Project::with('tasks')
                ->select(['project_name', 'id', 'client_id'])
                ->where('created_by', $user->id)
                ->get()
                ->toArray();
        }

        return $this->success([
            'projects' => $projects,
        ], 'Get Project List successfully.');
    }

    public function addTracker(Request $request)
    {
        $user = auth()->user();

        if ($request->has('action') && $request->action === 'start') {
            $validator = Validator::make($request->all(), [
                'task_id' => 'required|integer',
                'time' => 'nullable|date',
                'is_billable' => 'nullable|boolean',
                'workin_on' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 422);
            }

            $task = ProjectTask::find($request->task_id);

            if (!$task || !$this->canAccessProject($user, $task->project_id)) {
                return $this->error('Invalid task', 404);
            }

            TimeTracker::where('created_by', $user->id)
                ->where('is_active', 1)
                ->update([
                    'end_time' => now(),
                    'is_active' => 0,
                ]);

            $tracker = TimeTracker::create([
                'name' => $request->input('workin_on', ''),
                'project_id' => $task->project_id,
                'is_billable' => $request->boolean('is_billable'),
                'tag_id' => $request->input('workin_on', ''),
                'start_time' => $request->filled('time')
                    ? date('Y-m-d H:i:s', strtotime($request->input('time')))
                    : now(),
                'task_id' => $task->id,
                'created_by' => $user->id,
            ]);

            $tracker->action = 'start';

            return $this->success($tracker, 'Track successfully create.');
        }

        return $this->stopTracker($request);
    }

    public function stopTracker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'traker_id' => 'required_without:tracker_id|integer',
            'tracker_id' => 'required_without:traker_id|integer',
            'time' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422);
        }

        $trackerId = $request->input('tracker_id', $request->input('traker_id'));

        $tracker = TimeTracker::where('id', $trackerId)
            ->where('created_by', auth()->id())
            ->first();

        if (!$tracker) {
            return $this->error('Track not found', 404);
        }

        $tracker->end_time = $request->filled('time')
            ? date('Y-m-d H:i:s', strtotime($request->input('time')))
            : now();
        $tracker->is_active = 0;
        $tracker->total_time = Utility::diffance_to_time($tracker->start_time, $tracker->end_time);
        $tracker->save();

        return $this->success($tracker, 'Stop time successfully.');
    }

    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tracker_id' => 'required|integer',
            'img' => 'required|string',
            'imgName' => 'nullable|string|max:255',
            'time' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422);
        }

        $tracker = TimeTracker::where('id', $request->tracker_id)
            ->where('created_by', auth()->id())
            ->first();

        if (!$tracker) {
            return $this->error('Track not found', 404);
        }

        $encoded = preg_replace('#^data:image/[^;]+;base64,#', '', $request->img);
        $imageBinary = base64_decode($encoded, true);

        if ($imageBinary === false || strlen($imageBinary) > 8 * 1024 * 1024) {
            return $this->error('Invalid image', 422);
        }

        $imageInfo = @getimagesizefromstring($imageBinary);
        if ($imageInfo === false) {
            return $this->error('Invalid image', 422);
        }

        $allowedTypes = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG => 'png',
            IMAGETYPE_WEBP => 'webp',
        ];

        if (!isset($allowedTypes[$imageInfo[2]])) {
            return $this->error('Unsupported image format', 422);
        }

        $extension = $allowedTypes[$imageInfo[2]];
        $file = Str::random(32) . '.' . $extension;
        $relativeDir = 'uploads/traker_images/' . $tracker->id;
        $absoluteDir = storage_path($relativeDir);

        if (!is_dir($absoluteDir) && !mkdir($absoluteDir, 0755, true) && !is_dir($absoluteDir)) {
            return $this->error('Unable to create image directory', 500);
        }

        $absolutePath = $absoluteDir . DIRECTORY_SEPARATOR . $file;

        if (file_put_contents($absolutePath, $imageBinary) === false) {
            return $this->error('Unable to save image', 500);
        }

        $photo = new TrackPhoto();
        $photo->track_id = $tracker->id;
        $photo->user_id = auth()->id();
        $photo->img_path = $relativeDir . '/' . $file;
        $photo->time = $request->time ?: now();
        $photo->status = 1;
        $photo->save();

        return $this->success([], 'Uploaded successfully.');
    }

    private function canAccessProject($user, $projectId)
    {
        if ($user->isUser()) {
            return ProjectUser::where('project_id', $projectId)
                ->where('user_id', $user->id)
                ->exists();
        }

        return Project::where('id', $projectId)
            ->where('created_by', $user->id)
            ->exists();
    }
}
