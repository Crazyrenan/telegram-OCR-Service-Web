@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Vendor</h1>

    <form action="{{ route('vendors.manage.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Vendor Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full form-input" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full form-input">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" name="phone" id="phone" class="mt-1 block w-full form-input">
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" id="address" rows="3" class="mt-1 block w-full form-input"></textarea>
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('vendors.manage.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Save Vendor</button>
        </div>
    </form>
</div>
@endsection
