@extends('layout')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md max-w-2xl mx-auto">
    <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-800">Process New Invoice</h1>
        <p class="text-gray-600 mt-2">Upload an invoice (JPEG, PNG, or PDF). The system will use OCR to read the contents and for approval.</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('ocr.process.request') }}" method="POST" enctype="multipart/form-data" class="mt-8">
        @csrf
        <div>
            <label for="invoice_file" class="block text-sm font-medium text-gray-700 mb-2">Invoice File</label>
            <input type="file" name="invoice_file" id="invoice_file" class="mt-1 block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100" required>
        </div>
        <div class="mt-6">
            <button type="submit" class="w-full btn-primary py-3">Upload and Process Invoice</button>
        </div>
    </form>
</div>
@endsection

