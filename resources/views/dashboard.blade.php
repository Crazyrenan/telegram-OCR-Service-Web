@extends('layout') {{-- Pastikan ini mengarah ke app.blade.php atau wrapper yang benar --}}

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-500 mt-1">Selamat datang kembali, {{ Auth::user()->name }} 👋</p>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('requests.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-lg shadow-primary-600/30">
                + New Request
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        <div class="md:col-span-4 bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between hover:border-primary-200 transition-all group">
            <div class="flex justify-between items-start">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
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

        <div class="md:col-span-4 bg-primary-900 p-6 rounded-3xl shadow-lg shadow-primary-900/20 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-800 rounded-bl-full -mr-8 -mt-8 opacity-50"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2 text-primary-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="text-sm font-medium">Pending Action</span>
                </div>
                <h3 class="text-5xl font-bold">{{ $pendingRequests }}</h3>
                <p class="text-sm text-primary-300 mt-1">Menunggu persetujuan Anda</p>
            </div>
            
            <a href="{{ route('requests.index') }}" class="relative z-10 mt-4 text-sm font-semibold text-white/80 hover:text-white flex items-center gap-1 group">
                Review Requests <span class="group-hover:translate-x-1 transition-transform">→</span>
            </a>
        </div>

        <div class="md:col-span-8 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Financial Overview</h3>
            <div class="grid grid-cols-2 gap-6">
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Spending This Month</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalSpendingThisMonth, 0, ',', '.') }}</p>
                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::now()->format('F Y') }}</span>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Upcoming Deliveries</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $upcomingDeliveries }}</p>
                    <span class="text-xs text-gray-400">Items arriving soon</span>
                </div>
            </div>
        </div>

        <div class="md:col-span-4 grid grid-rows-2 gap-6">
             <a href="{{ route('vendors.manage.index') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                     <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Manage Vendors</h4>
                    <p class="text-xs text-gray-500">Database & Contacts</p>
                </div>
             </a>

             <a href="{{ route('requests.create') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                     <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">New Request</h4>
                    <p class="text-xs text-gray-500">Submit purchase order</p>
                </div>
             </a>
        </div>

        @can('manage-users')
        <div class="md:col-span-12 mt-4">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Manager Tools</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('users.manage.index') }}" class="p-4 rounded-2xl bg-white border border-gray-100 hover:border-primary-300 transition-colors flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600">
                         <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <span class="font-semibold text-gray-700">User Management</span>
                </a>

                <a href="{{ route('reports.purchases.index') }}" class="p-4 rounded-2xl bg-white border border-gray-100 hover:border-primary-300 transition-colors flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600">
                         <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <span class="font-semibold text-gray-700">Purchase Reports</span>
                </a>

                <a href="{{ route('verifications.manage.index') }}" class="p-4 rounded-2xl bg-white border border-gray-100 hover:border-primary-300 transition-colors flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600">
                         <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <span class="font-semibold text-gray-700">Verifications</span>
                </a>
            </div>
        </div>
        @endcan

    </div>
</div>
@endsection