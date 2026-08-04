<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements.
     */
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new announcement.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'type' => 'required|in:general,event,payment,urgent',
            'priority' => 'required|integer|min:0|max:2',
            'is_pinned' => 'boolean',
            'attachment' => 'nullable|file|max:2048|mimes:pdf,doc,docx,jpg,png',
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('announcements', 'public');
        }

        $validated['user_id'] = auth()->id();
        
        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement created successfully!');
    }

    /**
     * Show the form for editing the announcement.
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the announcement.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'type' => 'required|in:general,event,payment,urgent',
            'priority' => 'required|integer|min:0|max:2',
            'is_pinned' => 'boolean',
            'attachment' => 'nullable|file|max:2048|mimes:pdf,doc,docx,jpg,png',
        ]);

        // Handle attachment removal
        if ($request->has('remove_attachment')) {
            Storage::delete('public/'.$announcement->attachment);
            $validated['attachment'] = null;
        }

        // Handle new file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($announcement->attachment) {
                Storage::delete('public/'.$announcement->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('announcements', 'public');
        }

        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated successfully!');
    }

    /**
     * Remove the announcement.
     */
    public function destroy(Announcement $announcement)
    {
        if ($announcement->attachment) {
            Storage::delete('public/'.$announcement->attachment);
        }
        
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted successfully!');
    }
}