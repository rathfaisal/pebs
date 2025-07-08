<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Activity;
use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (!$user || (!$user->is_super_admin && !$user->is_admin)) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

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
            $imageName = uniqid('activity_', true) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('activities', $imageName, 'public');
            $activity->picture = $imagePath;
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
            $imageName = uniqid('activity_', true) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('activities', $imageName, 'public');
            $activity->picture = $imagePath;
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

    public function gallery($activityId)
    {
        $activity = Activity::findOrFail($activityId);
        $gallery = $activity->galleries ?? [];
        return view('shared.activity.gallery', compact('activity', 'gallery'));
    }

    public function addGalleryImage($activityId)
    {
        $activity = Activity::findOrFail($activityId);
        return view('shared.activity.add_gallery_image', compact('activity'));
    }

    public function storeGalleryImage(Request $request, $activityId)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|max:2048',
        ]);

        $activity = Activity::findOrFail($activityId);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = uniqid('gallery_', true) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('galleries', $imageName, 'public');

                $gallery = new Gallery();
                $gallery->activity_id = $activity->id;
                $gallery->image_path = $imagePath;
                $gallery->save();
            }
        }

        return redirect()->route('s.activity.gallery', $activity->id)->with('success', 'Images added to gallery successfully.');
    }

    public function deleteGalleryImage($activityId, $galleryId)
    {
        $gallery = Gallery::where('activity_id', $activityId)->findOrFail($galleryId);
        // Delete the file from storage
        if ($gallery->image_path && \Storage::disk('public')->exists($gallery->image_path)) {
            \Storage::disk('public')->delete($gallery->image_path);
        }
        $gallery->delete();
        return redirect()->route('s.activity.gallery', $activityId)->with('success', 'Image deleted from gallery successfully.');
    }
}
