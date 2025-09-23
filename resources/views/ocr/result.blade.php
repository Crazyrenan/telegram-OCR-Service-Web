@extends('layout')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-[calc(100vh-200px)]">
    <!-- Image Column -->
    <div class="bg-white rounded-lg shadow p-4 flex flex-col">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 shrink-0">Uploaded Image</h2>
        <div class="relative h-full overflow-y-auto rounded-lg bg-gray-100 flex items-center justify-center p-4 border">
            @if(isset($path))
                <img src="{{ asset('storage/' . $path) }}" alt="Uploaded Image for OCR" class="max-w-full max-h-full object-contain rounded-md">
            @else
                <div class="text-center text-gray-500">
                    <p>Image not available.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Text Column -->
    <div class="bg-white rounded-lg shadow p-4 flex flex-col">
        <div class="flex items-center justify-between mb-4 shrink-0">
            <h2 class="text-xl font-semibold text-gray-800">Extracted Text</h2>
            <a href="{{ route('ocr.upload.form') }}" class="btn-secondary text-sm">Try Another</a>
        </div>
        <div class="relative h-full overflow-y-auto rounded-md bg-gray-50 border">
            <pre id="textContent" class="p-4 font-mono text-sm text-gray-700 leading-relaxed whitespace-pre-wrap break-words">{{ $text ?? 'No text was found.' }}</pre>
        </div>
    </div>
</div>
@endsection

