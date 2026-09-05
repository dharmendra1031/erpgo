<?php

namespace App\Http\Controllers;

use App\Models\TimeTracker;
use App\Models\TrackPhoto;
use App\Models\Utility;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TimeTrackerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $treckers = TimeTracker::where('created_by', Auth::id())->get();

        return view('time_trackers.index', compact('treckers'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(TimeTracker $timeTracker)
    {
        //
    }

    public function edit(TimeTracker $timeTracker)
    {
        //
    }

    public function update(Request $request, TimeTracker $timeTracker)
    {
        //
    }

    public function destroy($timetracker_id)
    {
        $tracker = $this->authorizedTracker($timetracker_id, true);

        $photos = TrackPhoto::where('track_id', $tracker->id)->get();
        foreach ($photos as $photo) {
            if (!empty($photo->img_path)) {
                File::delete(storage_path($photo->img_path));
            }
            $photo->delete();
        }

        $tracker->delete();

        return redirect()->back()->with('success', __('TimeTracker successfully deleted.'));
    }

    public function getTrackerImages(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $tracker = $this->authorizedTracker($request->id, false);
        $images = TrackPhoto::where('track_id', $tracker->id)->get();

        return view('time_trackers.images', compact('images', 'tracker'));
    }

    public function removeTrackerImages(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $image = TrackPhoto::find($request->id);

        if (!$image) {
            return Utility::error_res(__('Tracker photo not found.'));
        }

        $this->authorizedTracker($image->track_id, true);

        $url = $image->img_path;

        if ($image->delete()) {
            if (!empty($url)) {
                File::delete(storage_path($url));
            }

            return Utility::success_res(__('Tracker Photo removed successfully.'));
        }

        return Utility::error_res(__('Something went wrong.'));
    }

    public function removeTracker(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $tracker = $this->authorizedTracker($request->input('id'), true);
        $tracker->delete();

        return Utility::success_res(__('Track removed successfully.'));
    }

    private function authorizedTracker($trackerId, $destructive)
    {
        $tracker = TimeTracker::findOrFail($trackerId);
        $currentUser = Auth::user();

        if ((int) $tracker->created_by === (int) $currentUser->id) {
            return $tracker;
        }

        $owner = User::find($tracker->created_by);
        $sameTenant = $owner
            && (int) $owner->creatorId() === (int) $currentUser->creatorId();

        if (!$sameTenant) {
            abort(403);
        }

        if ($destructive && !$currentUser->can('delete timesheet')) {
            abort(403);
        }

        return $tracker;
    }
}
