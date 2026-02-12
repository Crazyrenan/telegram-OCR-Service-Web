@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Vendors</h1>
        <a href="{{ route('vendors.manage.create') }}" class="btn-primary">
            + Add New Vendor
        </a>
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
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">ID</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Name</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Email</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Phone</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($vendors as $vendor)
                    <tr class="hover:bg-gray-100 border-b">
                        <td class="py-3 px-4">{{ $vendor->id }}</td>
                        <td class="py-3 px-4 font-bold">{{ $vendor->name }}</td>
                        <td class="py-3 px-4">{{ $vendor->email ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $vendor->phone ?? '-' }}</td>
                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('vendors.manage.edit', $vendor->id) }}" class="text-blue-500 hover:text-blue-700 font-semibold">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No vendors found in the database.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $vendors->links() }}
        </div>
    </div>
</div>
@endsection
