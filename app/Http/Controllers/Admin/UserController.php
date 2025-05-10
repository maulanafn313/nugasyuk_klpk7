<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')
                    ->orderBy('name')
                    ->paginate(25); // Menampilkan 25 item per halaman
        return view('admin.userManagement.index', compact('users'));
    }

    public function create()
    {
        return view('admin.userManagement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'province' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
        ]);

        return redirect()->route('admin.userManagement.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.userManagement.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,$user->id",
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'province' => 'nullable|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
        ]);

        return redirect()->route('admin.userManagement.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.userManagement.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}

