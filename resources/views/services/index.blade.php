@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md max-w-3xl mx-auto" x-data="{ service: 'none' }">
    <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-800">Create a New Request</h1>
        <p class="text-gray-600 mt-2">Please select a service type from the dropdown below to get started.</p>
    </div>

    <!-- Service Selector Dropdown -->
    <div class="mt-8">
        <label for="service_type" class="block text-sm font-medium text-gray-700">Select Service</label>
        <select id="service_type" name="service_type" x-model="service" class="mt-1 block w-full form-input">
            <option value="none" disabled>-- Please choose an option --</option>
            <option value="item_request">New Item Request (Manual)</option>
            <option value="invoice_ocr">Process from Invoice (OCR)</option>
        </select>
    </div>

    <!-- Conditional Forms -->
    <div class="mt-6">
        {{-- Manual Item Request Form --}}
        <div x-show="service === 'item_request'" x-transition>
            <form action="{{ route('services.process') }}" method="POST">
                @csrf
                <input type="hidden" name="service_type" value="item_request">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Manual Item Request Form</h3>
                <div class="space-y-4">
                    <div>
                        <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
                        <input type="text" name="item_name" id="item_name" class="mt-1 block w-full form-input" required>
                    </div>
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount (in Rp)</label>
                        <input type="number" name="amount" id="amount" step="0.01" class="mt-1 block w-full form-input" required>
                    </div>
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Purchase</label>
                        <textarea name="reason" id="reason" rows="3" class="mt-1 block w-full form-input" required></textarea>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-full btn-primary py-2">Submit Manual Request</button>
                </div>
            </form>
        </div>

        {{-- Invoice OCR Upload Form --}}
        <div x-show="service === 'invoice_ocr'" x-transition>
             <form action="{{ route('services.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="service_type" value="invoice_ocr">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Invoice Processing Form</h3>
                <div>
                    <label for="invoice_file" class="block text-sm font-medium text-gray-700 mb-2">Invoice File (Image or PDF)</label>
                    <input type="file" name="invoice_file" id="invoice_file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-full btn-primary py-2">Upload and Process Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
