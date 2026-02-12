@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-gray-800 tracking-tight">Search Your Document Library</h1>
        <p class="mt-3 text-lg text-gray-600">Find any document by searching for its content.</p>
    </div>

    <form action="{{ route('search.results') }}" method="GET" class="flex gap-2 max-w-2xl mx-auto">
        <input type="search" name="query" placeholder="Enter keywords, phrases, or sentences..." value="{{ $query ?? '' }}" required class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
        <button type="submit" class="btn-primary">Search</button>
    </form>

    @if(isset($documents))
    <div class="mt-12">
        @if(isset($query))
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Results for <span class="text-blue-500">"{{ $query }}"</span></h2>
        @else
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">All Uploaded Documents</h2>
        @endif

        @if($documents->isEmpty())
            <div class="text-center py-16 px-8 bg-gray-50 border border-dashed border-gray-300 rounded-lg">
                <h3 class="mt-4 text-lg font-medium text-gray-900">No documents found</h3>
                <p class="mt-2 text-sm text-gray-500">
                    @if(isset($query))
                        We couldn't find any documents matching your search. Try different keywords.
                    @else
                        You haven't uploaded any documents yet. <a href="{{ route('ocr.upload.form') }}" class="text-blue-500 hover:underline">Upload one now</a>.
                    @endif
                </p>
            </div>
        @else
            {{-- NEW: A more visual grid layout for the results --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($documents as $doc)
                    @php
                        $isPdf = Str::endsWith(strtolower($doc->stored_path), '.pdf');
                        $viewRoute = $isPdf ? route('document.viewer', ['id' => $doc->id]) : route('image.viewer', ['id' => $doc->id]);
                        // This logic correctly gets the thumbnail for PDFs or the original image for JPEGs/PNGs
                        $thumbnailUrl = $isPdf && $doc->thumbnail_path ? asset($doc->thumbnail_path) : asset('storage/' . $doc->stored_path);
                    @endphp
                    <a href="{{ $viewRoute }}" class="block bg-white border border-gray-200 rounded-lg shadow group overflow-hidden transition-shadow duration-300 hover:shadow-xl">
                        {{-- Thumbnail Image --}}
                        <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                            <img src="{{ $thumbnailUrl }}" alt="Thumbnail for {{ $doc->original_filename }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                        {{-- Card Content --}}
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-blue-600 truncate group-hover:text-blue-800">{{ $doc->original_filename }}</h3>
                            <p class="mt-2 text-sm text-gray-500 leading-relaxed line-clamp-3">
                                {{ Str::limit(preg_replace('/\s+/', ' ', $doc->extracted_text), 120) }}
                            </p>
                            <div class="mt-4 text-xs text-gray-400">
                                <span>Uploaded: {{ $doc->created_at->toFormattedDateString() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- NEW: Pagination Links --}}
            <div class="mt-8">
                {{ $documents->links() }}
            </div>
        @endif
    </div>
    @endif
</div>
@endsection

