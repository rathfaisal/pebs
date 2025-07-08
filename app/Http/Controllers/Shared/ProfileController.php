<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('shared.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('shared.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'old_password' => 'required|string',
            ]);

            if (!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {
                return back()->withErrors([
                    'old_password' => 'The provided password does not match our records.',
                ]);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->route('shared.profile.show')->with('success', 'Profile updated successfully.');
    }
}
