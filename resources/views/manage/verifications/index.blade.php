@extends('layout')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Document Verifications</h1>
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
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Submitted By</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Document</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Status</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($requests as $request)
                    <tr class="hover:bg-gray-100 border-b">
                        <td class="py-3 px-4">{{ $request->created_at->format('Y-m-d H:i') }}</td>
                        <td class="py-3 px-4">{{ $request->user->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $request->original_filename }}</td>
                        <td class="py-3 px-4">{{ $request->extracted_name }}</td>
                        <td class="py-3 px-4 text-center">
                             @if($request->status == 'pending')
                                <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs">Pending</span>
                            @elseif($request->status == 'verified')
                                <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Verified</span>
                            @else
                                <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs">Rejected</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if($request->status == 'pending')
                                <form action="{{ route('verifications.manage.resend', $request->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-secondary text-xs px-3 py-2 whitespace-nowrap">Resend Notification</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No verification requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
