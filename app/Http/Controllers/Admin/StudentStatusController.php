<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentStatusController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')
            ->orderBy('name')
            ->get();
            
        return view('admin.students.status', compact('students'));
    }

    public function updateStatus(Request $request, $id)
    {
        $student = User::findOrFail($id);
        
        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        $student->update([
            'is_active' => $request->is_active
        ]);

        return redirect()->back()->with('success', 'Status mahasiswa berhasil diperbarui');
    }
} 