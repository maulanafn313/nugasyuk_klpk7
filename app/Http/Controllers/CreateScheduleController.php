<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;


use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateScheduleController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        return view('create-schedule', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
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
            'collaborators.*.user_id' => 'nullable|exists:users,id',
            'collaborators.*.role' => 'nullable|in:viewer,editor',
        ]);

        //simpan data jika file ada
        if($request->hasFile('upload_file')){
            $data['upload_file'] = $request->file('upload_file')->store('files');
        }

        //simpan data ke database
        $schedule = Auth::user()->schedulesCreated()->create($data);

        $attachData = [
            Auth::id() => ['role' => 'owner'],    // si pembuat
        ];
        
        foreach ($request->input('collaborators', []) as $collab) {
            $userId = $collab['user_id'] ?? null;
            $role   = $collab['role']    ?? 'viewer';
        
            if ($userId
                && $userId !== Auth::id()
                && in_array($role, ['viewer','editor'], true)
            ) {
                // kalau ada duplikasi di input, key akan ditimpa, jadi aman
                $attachData[$userId] = ['role' => $role];
            }
        }
        
        // lalu satu kali kirim ke pivot table tanpa melepas entri lama
        $schedule->collaborators()->syncWithoutDetaching($attachData);

        return redirect()->route('user.view-schedule')->with('success', 'Schedule created successfully');
        
    }

}
