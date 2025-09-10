@extends('layout')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-700">Items List</h1>
        <div class="flex space-x-2">
            <!-- This is the new button and form -->
            <form action="{{ route('items.sendToTelegram') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Send List to Telegram
                </button>
            </form>
            <a href="{{ route('items.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Add New Item
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <table class="min-w-full bg-white">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">ID</th>
                <th class="w-2/6 text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                <th class="w-2/6 text-left py-3 px-4 uppercase font-semibold text-sm">Description</th>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @forelse ($items as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="text-left py-3 px-4">{{ $item->id }}</td>
                    <td class="text-left py-3 px-4">{{ $item->name }}</td>
                    <td class="text-left py-3 px-4">{{ Str::limit($item->description, 50) }}</td>
                    <td class="text-left py-3 px-4">
                        <a href="{{ route('items.edit', $item->id) }}" class="text-blue-500 hover:text-blue-800 font-semibold">Edit</a>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline-block ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-800 font-semibold" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4">No items found. Click "Add New Item" to get started!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

