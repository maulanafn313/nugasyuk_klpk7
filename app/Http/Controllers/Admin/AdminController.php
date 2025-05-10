<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil data user per hari dalam 7 hari terakhir
        $userData = [];
        $taskData = [];
        $labels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('l');
            
            // Hitung jumlah user yang dibuat pada hari tersebut
            $userCount = User::whereDate('created_at', $date->format('Y-m-d'))->count();
            $userData[] = $userCount;
            
            // Hitung jumlah task yang dibuat pada hari tersebut
            $taskCount = Schedule::whereDate('created_at', $date->format('Y-m-d'))->count();
            $taskData[] = $taskCount;
        }

        return view('admin.dashboard', compact('userData', 'taskData', 'labels'));
    }
}
