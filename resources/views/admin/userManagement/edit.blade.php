@extends('layouts.admin')

@section('content')
    <div class="p-6 max-w-xl">
        <h1 class="text-2xl font-bold mb-4">Edit User</h1>

        <form action="{{ route('admin.userManagement.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Password (leave blank if unchanged)</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        </form>
    </div>
@endsection
