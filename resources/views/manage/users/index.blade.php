@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Users & Roles</h1>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Name</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Email</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Current Role</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center" style="width: 250px;">Change Role</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-100 border-b">
                        <td class="py-3 px-4">{{ $user->name }}</td>
                        <td class="py-3 px-4">{{ $user->email }}</td>
                        <td class="py-3 px-4 text-center">
                             @if($user->role == 'manager')
                                <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs font-bold">Manager</span>
                            @else
                                <span class="bg-gray-200 text-gray-800 py-1 px-3 rounded-full text-xs">User</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('users.manage.updateRole', $user->id) }}" method="POST" class="flex items-center justify-center space-x-2">
                                @csrf
                                <select name="role" class="form-input w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="user" @if($user->role == 'user') selected @endif>User</option>
                                    <option value="manager" @if($user->role == 'manager') selected @endif>Manager</option>
                                </select>
                                <button type="submit" class="btn-primary text-xs px-3 py-2 whitespace-nowrap">Save</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
