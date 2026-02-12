<x-app-layout>
    {{-- Slot Header (Otomatis masuk ke tempat header di layout) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Dokumen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    
                    {{-- Header Section --}}
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">Scan Dokumen Anda</h3>
                        <p class="text-gray-500 mt-2">Kami akan mengekstrak teks dari gambar secara otomatis.</p>
                    </div>

                    <form action="{{ route('ocr.process.request') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-primary-300 border-dashed rounded-xl cursor-pointer bg-primary-50 hover:bg-primary-100 transition duration-300 ease-in-out group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    {{-- Icon Upload --}}
                                    <svg class="w-12 h-12 mb-4 text-primary-500 group-hover:scale-110 transition-transform" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-600"><span class="font-bold text-primary-600">Klik untuk upload</span> atau seret file ke sini</p>
                                    <p class="text-xs text-gray-400">PNG, JPG or JPEG (MAX. 2MB)</p>
                                </div>
                                
                                {{-- PERBAIKAN PENTING: name="invoice_file" agar sesuai Controller --}}
                                <input id="dropzone-file" name="invoice_file" type="file" class="hidden" onchange="previewImage(event)" required />
                            </label>
                        </div>

                        {{-- Image Preview Container --}}
                        <div id="preview-container" class="hidden mt-4 text-center">
                            <p class="text-sm text-gray-500 mb-2">Preview:</p>
                            <img id="preview-img" class="max-h-64 mx-auto rounded-lg shadow-md" src="#" alt="Image preview" />
                        </div>

                        <div class="flex justify-end">
                            {{-- Tombol Submit --}}
                            <button type="submit" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 rounded-lg text-white font-semibold shadow-lg transform hover:-translate-y-0.5 transition-all">
                                {{ __('Proses OCR Sekarang') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Preview --}}
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('preview-img');
                const container = document.getElementById('preview-container');
                output.src = reader.result;
                container.classList.remove('hidden');
            };
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>