<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;

class AnnouncementController extends Controller
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
        $announcements = Announcement::all();
        return view('shared.announcement.index', compact('announcements'));
    }

    public function create()
    {
        return view('shared.announcement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid('announcement_', true) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('announcements', $imageName, 'public');
            $data['image_path'] = $imagePath;
        }

        Announcement::create($data);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('shared.announcement.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $announcement = Announcement::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($announcement->image_path) {
                Storage::delete($announcement->image_path);
            }

            $image = $request->file('image');
            $imageName = uniqid('announcement_', true) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('announcements', $imageName, 'public');
            $data['image_path'] = $imagePath;
        }

        $announcement->update($data);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement updated successfully');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        if ($announcement->image_path) {
            Storage::delete($announcement->image_path);
        }

        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement deleted successfully');
    }
}
