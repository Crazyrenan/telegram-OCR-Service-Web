@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage Connected Telegram Users</h1>
    <p class="text-gray-600 mb-4">This table shows all Telegram accounts connected to the system. Removing a connection will instantly revoke that user's bot access.</p>

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
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Email (User Account)</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Role</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Telegram Chat ID</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($connections as $connection)
                    <tr class="hover:bg-gray-100 border-b">
                        <td class="py-3 px-4">{{ $connection->name }}</td>
                        <td class="py-3 px-4">{{ $connection->email }}</td>
                        <td class="py-3 px-4">{{ $connection->role }}</td>
                        <td class="py-3 px-4 font-mono text-xs">{{ $connection->chat_id }}</td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('users.telegram.remove', $connection->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to disconnect this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded">
                                    Remove Connection
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No users have connected their Telegram account yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6">
            {{ $connections->links() }}
        </div>
    </div>
</div>
@endsection

