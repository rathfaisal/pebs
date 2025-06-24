<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $registeredIds = $user->activities->pluck('id')->toArray();
        return view('user.index', compact('activities', 'registeredIds'));
    }

    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        $user = auth()->user();
        $isRegistered = $user->activities->contains($activity->id);
        return view('user.show', compact('activity', 'isRegistered'));
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
}
