<?php

namespace App\Http\Controllers\Api;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ScheduleResource;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where(function ($q){
            $q->where('user_id', Auth::id())
                ->orWhereHas('collaborators', fn($q) => $q->where('user_id'), Auth::id());
        })->with('collaborators')
            ->get();

        return ScheduleResource::collection($schedules);
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
            'collaborators' => 'nullable|array', // Tambahkan validasi untuk kolaborator
            'collaborators.*' => 'exists:users,id', // Pastikan setiap kolaborator adalah user yang valid
        ]);

        if($request->hasFile('upload_file'))
        {
            $data['upload_file'] = $request->file('upload_file')->store('files');
        }

        $schedule = Auth::user()->schedulesCreated()->create($data);

        // Tambahkan kolaborator ke jadwal
        if (!empty($data['collaborators'])) {
            $schedule->collaborators()->attach($data['collaborators'], ['role' => 'viewer']);
        }

        return new ScheduleResource($schedule);
    }

    public function show(Schedule $schedule)
    {
        $this->authorizeAccess($schedule);

        return new ScheduleResource($schedule);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $this->authorizeAccess($schedule);

        $data = $request->validate([
            'schedule_name' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'priority' => 'sometimes|required|in:very_important,important,not_important',
            'start_schedule' => 'sometimes|required|date',
            'due_schedule' => 'sometimes|required|date|after_or_equal:start_schedule',
            'before_due_schedule' => 'sometimes|required|date|before:due_schedule',
            'upload_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'url' => 'nullable|url',
            'description' => 'nullable|string',
            'status' => 'sometimes|string|in:to-do,processed,completed,overdue',
        ]);

        if ($request->hasFile('upload_file')) {
            if ($schedule->upload_file) {
                Storage::delete($schedule->upload_file);
            }
            $data['upload_file'] = $request->file('upload_file')->store('files');
        }

        $schedule->update($data);

        return new ScheduleResource($schedule->fresh());
    }

    public function destroy(Schedule $schedule)
    {
        $this->authorizeAccess($schedule);

        if ($schedule->upload_file) {
            Storage::delete($schedule->upload_file);
        }

        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully'], 200);
    }

    private function authorizeAccess(Schedule $schedule)
    {
        // Periksa apakah user adalah pemilik jadwal
        if ($schedule->user_id === Auth::id()) {
            return true;
        }

        // Periksa apakah user adalah kolaborator dengan peran yang diizinkan
        $userRole = $schedule->collaborators()
            ->where('user_id', Auth::id())
            ->first()?->pivot->role;

        if (!in_array($userRole, ['owner', 'editor'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
