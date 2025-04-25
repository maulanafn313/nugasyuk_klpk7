<?php

namespace App\Http\Controllers\User;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {

        // Ambil semua schedule yang terkait dengan user yang sedang login
        // baik sebagai owner maupun collaborator
        $schedules = Schedule::whereHas('collaborators', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        // Hitung jumlah schedule berdasarkan status
        $scheduleCounts = [
            'to-do' => $schedules->where('status', 'to-do')->count(),
            'processed' => $schedules->where('status', 'processed')->count(),
            'done' => $schedules->where('status', 'completed')->count(),
            'overdue' => $schedules->where('status', 'overdue')->count(),
        ];
        return view('dashboard', compact('scheduleCounts'));
    }
}
