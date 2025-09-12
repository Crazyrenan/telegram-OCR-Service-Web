@extends('layout')

@section('content')
<div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Submit a New Purchase Request</h1>

    <form action="{{ route('requests.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="item_name" class="block text-gray-700 text-sm font-bold mb-2">Item Name:</label>
            <input type="text" name="item_name" id="item_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount (in Rp):</label>
            <input type="number" name="amount" id="amount" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-6">
            <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">Reason for Purchase:</label>
            <textarea name="reason" id="reason" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Submit for Approval
            </button>
            <a href="{{ route('requests.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
