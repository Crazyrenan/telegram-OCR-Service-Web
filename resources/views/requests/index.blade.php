@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Your Purchase Requests</h1>
        {{-- The "+ New Request" button is now part of the main navigation, so we can remove it from here for a cleaner look --}}
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
     @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Date</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Item</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Amount</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Status</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($requests as $request)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 px-4">{{ $request->created_at->format('Y-m-d') }}</td>
                        <td class="py-3 px-4">{{ $request->item_name }}</td>
                        <td class="py-3 px-4">Rp {{ number_format($request->amount, 2, ',', '.') }}</td>
                        <td class="py-3 px-4 text-center">
                            @if($request->status == 'pending')
                                <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs">Pending</span>
                            @elseif($request->status == 'approved')
                                <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Approved</span>
                            @else
                                <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs">Rejected</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            {{-- Conditionally show the Edit and Resend buttons only for pending requests --}}
                            @if($request->status == 'pending')
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('requests.edit', $request->id) }}" class="text-blue-500 hover:text-blue-700 font-semibold text-xs">Edit</a>
                                    <form action="{{ route('requests.resend', $request->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-secondary text-xs px-2 py-1 whitespace-nowrap">Resend Alert</button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">You have not submitted any purchase requests yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

