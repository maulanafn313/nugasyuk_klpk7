<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('collaborators')->get();
        return view('view-schedule', compact('schedules'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        //check if user is owner or editor
        $userRole = $schedule->collaborators()->where('user_id', Auth::id())->first()?->pivot->role;
        if (!in_array($userRole, ['owner', 'editor'])) {
            abort(403);
        }

        $data = $request->validate([
            'schedule_name' => 'required|string',
            'schedule_category' => 'required|in:task,activities',
            'priority' => 'required|in:very_important,important,not_important',
            'start_schedule' => 'required|date',
            'due_schedule' => 'required|date|after_or_equal:start_schedule',
            'before_due_schedule' => 'required|date|before:due_schedule',
            'upload_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        if($request->hasFile('upload_file')){
            // Delete old file if exists
            if($schedule->upload_file) {
                Storage::delete($schedule->upload_file);
            }
            $data['upload_file'] = $request->file('upload_file')->store('files');
        }

        $schedule->update($data);
        
        return redirect()->route('user.view-schedule')->with('success', 'Schedule updated successfully');
    }

    public function destroy(Schedule $schedule)
    {
        //check if user is owner
        $userRole = $schedule->collaborators()->where('user_id', Auth::id())->first()?->pivot->role;
        if (!in_array($userRole, ['owner', 'editor'])) {
            abort(403);
        }
        
        // Delete file if exists
    if($schedule->upload_file) {
        Storage::delete($schedule->upload_file);
    }

    $schedule->delete();

    return redirect()->route('user.view-schedule')->with('success', 'Schedule deleted successfully');
    }

    public function getSchedules()
    {
        $schedules = Schedule::all()->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => $schedule->schedule_name,
                'start' => $schedule->start_schedule,
                'end' => $schedule->due_schedule,
                'description' => $schedule->description,
                'color' => $this->getPriorityColor($schedule->priority),
            ];
        });

        return response()->json($schedules);
    }

    private function getPriorityColor($priority)
    {
        return match($priority) {
            'very_important' => '#EF4444', // Merah
            'important' => '#F59E0B',      // Kuning
            'not_important' => '#3B82F6',  // Biru
            default => '#3B82F6'           // Default biru
        };
    }

    public function showCalendar()
    {
        $schedules = Schedule::all()->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => $schedule->schedule_name,
                'start' => $schedule->start_schedule,
                'end' => $schedule->due_schedule,
                'description' => $schedule->description,
                'color' => $this->getPriorityColor($schedule->priority),
            ];
        });
        return view('calendar', ['events' => $schedules]);
    }
}
