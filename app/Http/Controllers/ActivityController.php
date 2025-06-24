<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('users')->get();
        if (Auth::user()->is_super_admin) {
            $activities = Activity::withTrashed()->with('users')->get();
        }
        return view('shared.activity.index', compact('activities'));
    }

    public function create()
    {
        return view('shared.activity.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'picture' => 'nullable|image|max:2048',
            'location' => 'nullable',
        ]);

        $activity = new Activity();
        $activity->title = $request->title;
        $activity->description = $request->description;
        $activity->date = $request->date;
        $activity->location = $request->location;

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $activity->picture = $imageName;
        }

        $activity->save();

        return redirect()->route('s.activity.index')->with('success', 'Activity created successfully.');
    }

    public function edit(Activity $activity)
    {
        return view('shared.activity.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'picture' => 'nullable|image|max:2048',
            'location' => 'nullable',
        ]);

        $activity->title = $request->title;
        $activity->description = $request->description;
        $activity->date = $request->date;
        $activity->location = $request->location;

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $activity->picture = $imageName;
        }

        $activity->save();

        return redirect()->route('s.activity.index')->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('s.activity.index')->with('success', 'Activity deleted successfully.');
    }

    public function restore($id)
    {
        if (!Auth::user()->is_super_admin) {
            return redirect()->route('s.activity.index')->with('error', 'You do not have permission to restore activities.');
        }

        $activity = Activity::withTrashed()->findOrFail($id);
        $activity->restore();

        return redirect()->route('s.activity.index')->with('success', 'Activity restored successfully.');
    }

    public function registeredUsers($activityId)
    {
        $activity = Activity::findOrFail($activityId);
        $registeredUsers = $activity->users;
        return view('shared.activity.registered_users', compact('activity', 'registeredUsers'));
    }

    public function unregisterUser($activityId, $userId)
    {
        $activity = Activity::findOrFail($activityId);
        $activity->users()->detach($userId);
        return redirect()->route('s.activity.registeredUsers', $activityId)->with('success', 'User registration removed successfully.');
    }
}
