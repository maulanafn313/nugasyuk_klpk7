<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryScheduleController extends Controller
{
    
    public function index()
    {
        $completedSchedules = Schedule::where('status', 'completed')
            ->with(['category'])
            ->orderBy('completed_at', 'desc')
            ->get();

        return view('history-schedule', compact('completedSchedules'));
    }

    public function destroy(Schedule $schedule)
    {
        // Soft delete the schedule
        $schedule->delete();

        return redirect()->route('user.history-schedule')
            ->with('success', 'Schedule history has been deleted successfully.');
    }
}
