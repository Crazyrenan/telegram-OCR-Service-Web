@extends('layout')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage All Purchases</h1>
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
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">PO Number</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Item</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Vendor</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Project</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Current Status</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center" style="width: 250px;">Change Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($purchases as $purchase)
                    <tr class="hover:bg-gray-100 border-b">
                        <td class="py-3 px-4">{{ $purchase->purchase_order_number }}</td>
                        <td class="py-3 px-4">{{ $purchase->item_name }}</td>
                        <td class="py-3 px-4">{{ $purchase->vendor_name }}</td>
                        <td class="py-3 px-4">{{ $purchase->project_name }}</td>
                        <td class="py-3 px-4 text-center">
                             @if($purchase->status == 'Pending')
                                <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs">Pending</span>
                            @elseif($purchase->status == 'Approved')
                                <span class="bg-blue-200 text-blue-800 py-1 px-3 rounded-full text-xs">Approved</span>
                            @else
                                <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Delivered</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('purchases.manage.updateStatus', $purchase->id) }}" method="POST" class="flex items-center justify-center space-x-2">
                                @csrf
                                <select name="status" class="form-input w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="Pending" @if($purchase->status == 'Pending') selected @endif>Pending</option>
                                    <option value="Approved" @if($purchase->status == 'Approved') selected @endif>Approved</option>
                                    <option value="Delivered" @if($purchase->status == 'Delivered') selected @endif>Delivered</option>
                                </select>
                                <button type="submit" class="btn-primary text-xs px-3 py-2 whitespace-nowrap">Update</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No purchases found in the database.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6">
            {{ $purchases->links() }}
        </div>
    </div>
</div>
@endsection
