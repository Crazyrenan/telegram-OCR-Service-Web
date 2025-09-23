@extends('layout')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Purchase Request</h1>

    <form action="{{ route('requests.update', $request->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
                <input type="text" name="item_name" id="item_name" value="{{ old('item_name', $request->item_name) }}" class="mt-1 block w-full form-input" required>
            </div>
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount (in Rp)</label>
                <input type="number" name="amount" id="amount" value="{{ old('amount', $request->amount) }}" step="0.01" class="mt-1 block w-full form-input" required>
            </div>
            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Purchase</label>
                <textarea name="reason" id="reason" rows="3" class="mt-1 block w-full form-input" required>{{ old('reason', $request->reason) }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('requests.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Update Request</button>
        </div>
    </form>
</div>
@endsection
