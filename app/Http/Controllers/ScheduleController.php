<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $schedules = Schedule::where(function($q) {
                $q->where('user_id', Auth::id())
                    ->orWhereHas('collaborators', fn($q) => $q->where('user_id', Auth::id()));
            })
            ->with('collaborators')
            ->orderBy('due_schedule')
            ->get();

        return view('view-schedule', compact('schedules', 'categories'));
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
            'category_id' => 'required|exists:categories,id',
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
                Storage::disk('public')->delete($schedule->upload_file);
            }
            $data['upload_file'] = $request->file('upload_file')->store('files', 'public');
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
        Storage::disk('public')->delete($schedule->upload_file);
    }

    $schedule->delete();

    return redirect()->route('user.view-schedule')->with('success', 'Schedule deleted successfully');
    }

    // tandai completed (hanya owner)
    public function complete(Schedule $schedule)
    {
        $schedule->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);

        return redirect()->back()->with('success', 'Schedule marked as complete!');
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
                'color' => $this->getPriorityColor($schedule->priority ?? 'not_important'),
            ];
        });
        return view('calendar', ['events' => $schedules]);
    }

    private function getPriorityColor($priority)
    {
        return match($priority) {
            'very_important' => '#EF4444', // Merah
            'important' => '#F59E0B',      // Kuning
            'not_important' => '#3B82F6',  // Biru
            default => '#3B82F6'
        };
    }
}
