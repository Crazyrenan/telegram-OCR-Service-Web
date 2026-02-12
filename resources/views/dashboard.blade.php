@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div x-data="{ 
            activeSlide: 1, 
            slides: [1, 2, 3], 
            timer: null,
            startAutoSlide() { 
                this.timer = setInterval(() => { this.nextSlide() }, 5000); 
            },
            stopAutoSlide() {
                clearInterval(this.timer);
            },
            nextSlide() {
                this.activeSlide = this.activeSlide === this.slides.length ? 1 : this.activeSlide + 1;
            },
            prevSlide() {
                this.activeSlide = this.activeSlide === 1 ? this.slides.length : this.activeSlide - 1;
            }
         }" 
         x-init="startAutoSlide()"
         @mouseenter="stopAutoSlide()"
         @mouseleave="startAutoSlide()"
         class="relative rounded-2xl overflow-hidden shadow-lg border border-primary-100 bg-white mb-8 h-64 md:h-72">
        
        <div x-show="activeSlide === 1" 
             x-transition:enter="transition ease-out duration-500" 
             x-transition:enter-start="opacity-0 transform translate-x-10" 
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform -translate-x-10"
             class="absolute inset-0 bg-gradient-to-r from-primary-900 to-primary-700 flex items-center px-8 md:px-16 text-white">
            <div class="w-full md:w-2/3">
                <span class="inline-block py-1 px-3 rounded-full bg-accent-500 text-white text-xs font-bold mb-3 shadow-sm">SYSTEM UPDATE</span>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">Selamat Datang di TelePortal</h1>
                <p class="text-primary-100 text-sm md:text-base mb-6 max-w-lg">
                    Kelola permintaan pembelian, verifikasi vendor, dan digitalisasi dokumen arsip Anda dalam satu platform terintegrasi.
                </p>
                <a href="{{ route('services.index') }}" class="inline-flex items-center px-5 py-2.5 bg-white text-primary-800 rounded-lg font-semibold shadow hover:bg-gray-100 transition-colors">
                    + Buat Request Baru
                </a>
            </div>
            <div class="hidden md:block absolute right-16 top-1/2 transform -translate-y-1/2 opacity-20">
                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
            </div>
        </div>

        <div x-show="activeSlide === 2"
             x-transition:enter="transition ease-out duration-500" 
             x-transition:enter-start="opacity-0 transform translate-x-10" 
             x-transition:enter-end="opacity-100 transform translate-x-0"
             class="absolute inset-0 bg-white flex items-center px-8 md:px-16 text-gray-800">
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Status Terkini</h2>
                    <p class="text-gray-500 mb-4">Ringkasan cepat aktivitas Anda hari ini.</p>
                    <div class="flex gap-4">
                        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl">
                            <span class="block text-2xl font-bold text-yellow-700">{{ $pendingRequests ?? 0 }}</span>
                            <span class="text-xs text-yellow-600 font-semibold">Pending</span>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl">
                            <span class="block text-2xl font-bold text-blue-700">{{ $upcomingDeliveries ?? 0 }}</span>
                            <span class="text-xs text-blue-600 font-semibold">Pengiriman</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:flex justify-end">
                    <img src="https://illustrations.popsy.co/amber/success.svg" alt="Status Illustration" class="h-48 w-auto">
                </div>
            </div>
        </div>

        <div x-show="activeSlide === 3"
             x-transition:enter="transition ease-out duration-500" 
             x-transition:enter-start="opacity-0 transform translate-x-10" 
             x-transition:enter-end="opacity-100 transform translate-x-0"
             class="absolute inset-0 bg-primary-50 flex items-center px-8 md:px-16 text-primary-900">
            <div class="w-full md:w-2/3">
                <h2 class="text-3xl font-bold mb-2 text-primary-800">Coba Fitur OCR Scanner</h2>
                <p class="text-primary-700 mb-6 max-w-lg">
                    Tidak perlu ketik manual. Upload foto invoice atau surat jalan, sistem kami akan membaca datanya secara otomatis untuk Anda.
                </p>
                <a href="{{ route('ocr.upload.form') }}" class="inline-flex items-center px-5 py-2.5 bg-primary-700 text-white rounded-lg font-semibold shadow hover:bg-primary-800 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /></svg>
                    Mulai Scan Sekarang
                </a>
            </div>
             <div class="hidden md:block absolute right-10 bottom-0 opacity-80">
                <svg class="w-64 h-64 text-primary-200" fill="currentColor" viewBox="0 0 24 24"><path d="M15 3l4.54 4.54L21 9V21a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h10zm-1 0H5v18h14v-10h-5V3z"/></svg>
            </div>
        </div>

        <button @click="prevSlide()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-2 rounded-full backdrop-blur-sm transition-colors focus:outline-none" :class="activeSlide === 1 ? 'text-white' : 'text-gray-400 hover:text-gray-600'">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="nextSlide()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-2 rounded-full backdrop-blur-sm transition-colors focus:outline-none" :class="activeSlide === 1 ? 'text-white' : 'text-gray-400 hover:text-gray-600'">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <template x-for="slide in slides" :key="slide">
                <button @click="activeSlide = slide" 
                        class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                        :class="activeSlide === slide ? (activeSlide === 1 ? 'bg-white w-6' : 'bg-primary-600 w-6') : (activeSlide === 1 ? 'bg-white/50' : 'bg-gray-300')">
                </button>
            </template>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        <div class="md:col-span-4 bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between hover:border-primary-200 transition-all group">
            <div class="flex justify-between items-start">
                <div class="p-3 bg-primary-50 text-primary-600 rounded-2xl group-hover:bg-primary-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="text-xs font-semibold px-2 py-1 bg-gray-100 rounded-full text-gray-500">All Time</span>
            </div>
            <div class="mt-4">
                <h3 class="text-4xl font-bold text-gray-900">124</h3>
                <p class="text-sm text-gray-500 mt-1">Total Dokumen</p>
            </div>
        </div>
        
        <div class="md:col-span-4 bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between hover:border-accent-200 transition-all group">
            <div class="flex justify-between items-start">
                <div class="p-3 bg-accent-50 text-accent-600 rounded-2xl group-hover:bg-accent-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-semibold px-2 py-1 bg-accent-50 text-accent-700 rounded-full">95% Success</span>
            </div>
            <div class="mt-4">
                <h3 class="text-4xl font-bold text-gray-900">118</h3>
                <p class="text-sm text-gray-500 mt-1">Berhasil Discan</p>
            </div>
        </div>

        <div class="md:col-span-4 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Financial Overview</h3>
            <div class="space-y-4">
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Spending This Month</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalSpendingThisMonth ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Upcoming Deliveries</p>
                    <p class="text-2xl font-bold text-primary-600">{{ $upcomingDeliveries ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="md:col-span-12 grid grid-cols-1 md:grid-cols-2 gap-6">
             <a href="{{ route('vendors.manage.index') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                     <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Manage Vendors</h4>
                    <p class="text-xs text-gray-500">Database & Contacts</p>
                </div>
             </a>

             <a href="{{ route('services.index') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                     <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">New Request</h4>
                    <p class="text-xs text-gray-500">Manual or OCR Input</p>
                </div>
             </a>
        </div>

    </div>
</div>
@endsection