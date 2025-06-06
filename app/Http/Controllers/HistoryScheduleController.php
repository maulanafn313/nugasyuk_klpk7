<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryScheduleController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Jadwal yang dimiliki user (owner)
        $ownedSchedules = Schedule::where('status', 'completed')
            ->where('user_id', $user->id)
            ->with('category')
            ->orderBy('completed_at', 'desc')
            ->get();

        // Jadwal kolaborasi (bukan owner, tapi user sebagai kolaborator)
        $collabSchedules = $user->schedules()
            ->where('schedules.status', 'completed')
            ->where('schedules.user_id', '!=', $user->id) // tambahkan prefix tabel
            ->with('category')
            ->orderBy('schedules.completed_at', 'desc')
            ->get();

        return view('history-schedule', compact('ownedSchedules', 'collabSchedules'));
    }

    public function destroy(Schedule $schedule)
    {
        // Soft delete the schedule
        $schedule->delete();

        return redirect()->route('user.history-schedule')
            ->with('success', 'Schedule history has been deleted successfully.');
    }
}
