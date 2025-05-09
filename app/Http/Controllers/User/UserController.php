<?php

namespace App\Http\Controllers\User;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // public function index()
    // {

    //     // Ambil semua schedule yang terkait dengan user yang sedang login
    //     // baik sebagai owner maupun collaborator
    //     $schedules = Schedule::whereHas('collaborators', function ($query) {
    //         $query->where('user_id', Auth::id());
    //     })->get();

    //     // Hitung jumlah schedule berdasarkan status
    //     $scheduleCounts = [
    //         'to-do' => $schedules->where('status', 'to-do')->count(),
    //         'processed' => $schedules->where('status', 'processed')->count(),
    //         'done' => $schedules->where('status', 'completed')->count(),
    //         'overdue' => $schedules->where('status', 'overdue')->count(),
    //     ];
    //     return view('dashboard', compact('scheduleCounts'));
    // }

    public function index()
{
    // load semua schedule milik user (owner & collaborator)
    $schedules = Schedule::where(function($q) {
        $q->where('user_id', Auth::id())
            ->orWhereHas('collaborators', fn($q) => $q->where('user_id', Auth::id()));
    })->get();

    // building notifikasi
    $now = Carbon::now();
    $notifications = [];

    foreach ($schedules as $s) {
        $start = Carbon::parse($s->start_schedule);
        $due   = Carbon::parse($s->due_schedule);
        $rem   = Carbon::parse($s->before_due_schedule);
        $oneDayBeforeStart = $start->subDay();

        // akan segera dimulai (1 hari sebelum)
        if ($now->between($oneDayBeforeStart, $start, false) && $s->status === 'to-do') {
            $notifications[] = [
                'type'    => 'info',
                'message' => "Jadwal <strong>{$s->schedule_name}</strong> akan mulai pada <strong>{$start->format('d F Y H:i')}</strong>."
            ];
        }
        // sudah dimulai
        if ($now->between($start, $due, false) && $s->status === 'to-do') {
            $notifications[] = [
                'type'    => 'primary',
                'message' => "Jadwal <strong>{$s->schedule_name}</strong> sudah dimulai, saatnya dikerjakan!"
            ];
        }
        // mendekati deadline
        if ($now->between($rem, $due, false) && $s->status !== 'completed') {
            $notifications[] = [
                'type'    => 'warning',
                'message' => "Jadwal <strong>{$s->schedule_name}</strong> mendekati batas waktu <strong>{$due->format('d F Y H:i')}</strong>."
            ];
        }
        // overdue
        if ($now->gt($due) && $s->status !== 'completed') {
            $notifications[] = [
                'type'    => 'danger',
                'message' => "Jadwal <strong>{$s->schedule_name}</strong> sudah melewati batas waktu!"
            ];
        }
    }

    // hitung summary status
    $scheduleCounts = [
        'to-do'     => $schedules->where('status','to-do')->count(),
        'processed' => $schedules->where('status','processed')->count(),
        'done'      => $schedules->where('status','completed')->count(),
        'overdue'   => $schedules->where('status','overdue')->count(),
    ];

    return view('dashboard', compact('scheduleCounts','notifications'));
}
}
