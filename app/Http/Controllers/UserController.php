<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Activity;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->is_super_admin == true) {
                return redirect()->route('sa.admin.index');
            }
            if (auth()->check() && auth()->user()->is_admin == true) {
                return redirect()->route('s.activity.index');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $activities = Activity::all();
        $user = auth()->user();
        $registeredIds = $user ? $user->activities->pluck('id')->toArray() : [];
        $announcement = Announcement::latest()->first();
        return view('user.index', compact('activities', 'registeredIds', 'announcement'));
    }

    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        $user = auth()->user();
        $isRegistered = $user ? $user->activities->contains($activity->id) : false;
        $existingFeedback = $user && $isRegistered ? $user->activities()->where('activity_id', $id)->first()->pivot->feedback ?? '' : '';
        return view('user.show', compact('activity', 'isRegistered', 'existingFeedback'));
    }
    
    public function register($id)
    {
        $activity = Activity::findOrFail($id);
        $user = auth()->user();
        // Attach only if not already registered
        if (!$user->activities->contains($activity->id)) {
            $user->activities()->attach($activity->id);
        }
        return redirect()->route('user.activity.show', $activity->id)->with('success', 'You have registered for this activity.');
    }

    public function feedback(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string|max:1000',
        ]);
        $user = auth()->user();
        $activity = Activity::findOrFail($id);
        // Only allow feedback if user is registered
        if (!$user->activities->contains($activity->id)) {
            return redirect()->route('user.activity.show', $activity->id)->with('error', 'You are not registered for this activity.');
        }
        // Save feedback in the pivot table
        $user->activities()->updateExistingPivot($activity->id, [
            'feedback' => $request->feedback,
        ]);
        return redirect()->route('user.activity.show', $activity->id)->with('success', 'Thank you for your feedback!');
    }
}
