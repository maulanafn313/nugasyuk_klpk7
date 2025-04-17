<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateScheduleController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('create-schedule', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_name' => 'required|string|max:255',
            'schedule_category' => 'required|in:task,activities',
            'priority' => 'required|in:important,very important,not important',
            'start_schedule' => 'required|date',
            'due_schedule' => 'required|date|after:start_schedule',
            'before_start_schedule' => 'required|date|before:start_schedule',
            'upload_file' => 'nullable|file|max:10240', // 10MB max
            'url' => 'nullable|url',
            'description' => 'required|string',
            'collaborators' => 'array',
            'collaborators.*.user_id' => 'required|exists:users,id',
            'collaborators.*.role' => 'required|in:editor,viewer',
        ]);

        // Handle file upload
        if ($request->hasFile('upload_file')) {
            $path = $request->file('upload_file')->store('schedule_files');
            $validated['upload_file'] = $path;
        }

        // Create schedule
        $schedule = Schedule::create([
            'user_id' => Auth::id(),
            'schedule_name' => $validated['schedule_name'],
            'schedule_category' => $validated['schedule_category'],
            'priority' => $validated['priority'],
            'start_schedule' => $validated['start_schedule'],
            'due_schedule' => $validated['due_schedule'],
            'before_start_schedule' => $validated['before_start_schedule'],
            'upload_file' => $validated['upload_file'] ?? null,
            'url' => $validated['url'] ?? null,
            'description' => $validated['description'],
            'status' => 'to-do',
        ]);

        // Add owner as collaborator
        $schedule->collaborators()->attach(Auth::id(), ['role' => 'owner']);

        // Add other collaborators
        if (isset($validated['collaborators'])) {
            foreach ($validated['collaborators'] as $collaborator) {
                $schedule->collaborators()->attach($collaborator['user_id'], ['role' => $collaborator['role']]);
            }
        }

        return redirect()->route('user.view-schedule')->with('success', 'Schedule created successfully!');
    }
}
