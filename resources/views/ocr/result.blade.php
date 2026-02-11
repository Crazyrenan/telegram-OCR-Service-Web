<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Card Container --}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl grid grid-cols-1 md:grid-cols-2 gap-0">
            
            {{-- Kolom Kiri: Gambar Asli --}}
            <div class="p-6 bg-gray-100 border-r border-gray-200 flex flex-col items-center justify-center">
                <span class="mb-4 px-3 py-1 bg-gray-200 text-gray-600 text-xs font-bold uppercase tracking-wide rounded-full">Dokumen Asli</span>
                <img src="{{ asset('storage/' . $ocrDocument->image_path) }}" class="max-w-full h-auto rounded-lg shadow-sm hover:scale-105 transition-transform duration-300" alt="Dokumen">
            </div>

            {{-- Kolom Kanan: Hasil Teks --}}
            <div class="p-8 relative">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Hasil Ekstraksi
                    </h3>
                    
                    {{-- Tombol Copy --}}
                    <button onclick="copyText()" class="text-xs flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-semibold bg-indigo-50 px-3 py-1 rounded transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Salin Teks
                    </button>
                </div>

                {{-- Text Area Hasil --}}
                <textarea id="resultText" class="w-full h-96 p-4 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700 font-mono text-sm leading-relaxed resize-none" readonly>{{ $ocrDocument->extracted_text }}</textarea>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('ocr.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                        &larr; Kembali
                    </a>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium shadow-md">
                        Simpan ke Database
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function copyText() {
        var copyText = document.getElementById("resultText");
        copyText.select();
        navigator.clipboard.writeText(copyText.value);
        alert("Teks berhasil disalin!"); // Bisa diganti dengan Toast notification agar lebih 'humane'
    }
</script>