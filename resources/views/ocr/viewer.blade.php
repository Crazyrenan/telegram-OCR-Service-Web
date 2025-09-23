@extends('layout')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-[calc(100vh-150px)]">
    <!-- PDF Column -->
    <div class="bg-white rounded-lg shadow p-4 flex flex-col">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 shrink-0">Document Preview</h2>
        <div class="flex-grow overflow-y-auto bg-gray-200 p-2 rounded">
             <div id="pdf-viewer" class="flex flex-col items-center gap-4"></div>
        </div>
    </div>

    <!-- Text Column -->
    <div class="bg-white rounded-lg shadow p-4 flex flex-col">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 shrink-0">Extracted Text</h2>
        <div class="relative mb-4 shrink-0">
            <input type="text" id="textSearchInput" placeholder="Search in text..." class="form-input w-full pl-10">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        <div class="relative h-full overflow-y-auto rounded-md bg-gray-50 border">
            <pre id="textContent" class="p-4 font-mono text-sm text-gray-700 leading-relaxed whitespace-pre-wrap break-words">{{ $document->extracted_text }}</pre>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<script>
    // This script will only run on this page
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';
    const pdfUrl = "{{ asset('storage/' . $document->stored_path) }}";
    const viewer = document.getElementById('pdf-viewer');
    
    pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
            pdf.getPage(pageNum).then(function(page) {
                const scale = 1.5;
                const viewport = page.getViewport({ scale: scale });
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                canvas.style.maxWidth = '100%';
                canvas.style.height = 'auto';
                canvas.className = 'rounded shadow';
                viewer.appendChild(canvas);
                page.render({ canvasContext: context, viewport: viewport });
            });
        }
    });

    const textContentElement = document.getElementById('textContent');
    const textSearchInput = document.getElementById('textSearchInput');
    const originalText = textContentElement.innerHTML;

    function performTextSearch() {
        const query = textSearchInput.value;
        textContentElement.innerHTML = originalText;
        if (!query.trim()) return;
        const regex = new RegExp(query, 'gi');
        textContentElement.innerHTML = originalText.replace(regex, (match) => `<mark style="background-color: #fef08a;">${match}</mark>`);
    }
    textSearchInput.addEventListener('keyup', (e) => performTextSearch());
</script>
@endpush
