@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">User Management</h1>
        <a href="{{ route('admin.userManagement.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Create User</a>

        <table class="w-full mt-6 bg-white rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4">Name</th>
                    <th class="py-2 px-4">Email</th>
                    <th class="py-2 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t">
                        <td class="py-2 px-4">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4">{{ $user->name }}</td>
                        <td class="py-2 px-4">{{ $user->email }}</td>
                        <td class="py-2 px-4 space-x-2">
                            <a href="{{ route('admin.userManagement.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.userManagement.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
