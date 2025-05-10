<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $startDate = Carbon::now()->subDays(29); // 29 karena dihitung sampai hari ini
        $labels = [];
        $userData = [];
        $taskData = [];

        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i);
            $formattedDate = $date->format('Y-m-d');
            $labels[] = $formattedDate;

            $userCount = User::whereDate('created_at', $formattedDate)->count();
            $taskCount = Task::whereDate('created_at', $formattedDate)->count();

            $userData[] = $userCount;
            $taskData[] = $taskCount;
        }

        return view('admin.dashboard', compact('labels', 'userData', 'taskData'));
    }
}
