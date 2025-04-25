<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

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
}
