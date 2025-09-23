@extends('layout')

@section('content')
<div class="px-4">
    <!-- Welcome Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-600 mt-1">Here's a snapshot of your application's current activity.</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Pending Approvals Card -->
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pending Approvals</h3>
            <p class="mt-2 text-4xl font-bold text-yellow-500">{{ $pendingRequests }}</p>
            <p class="mt-1 text-sm text-gray-500">requests waiting for action</p>
        </div>

        <!-- Upcoming Deliveries Card -->
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Upcoming Deliveries</h3>
            <p class="mt-2 text-4xl font-bold text-blue-500">{{ $upcomingDeliveries }}</p>
            <p class="mt-1 text-sm text-gray-500">items scheduled for delivery</p>
        </div>

        <!-- Monthly Spending Card -->
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Spending This Month</h3>
            <p class="mt-2 text-4xl font-bold text-green-500">Rp {{ number_format($totalSpendingThisMonth, 0, ',', '.') }}</p>
            <p class="mt-1 text-sm text-gray-500">for {{ \Carbon\Carbon::now()->format('F') }}</p>
        </div>
    </div>

    <!-- User Action Cards -->
    <div class="grid md:grid-cols-2 gap-8">
        <a href="{{ route('vendors.manage.index') }}" class="block bg-white rounded-lg shadow-lg p-8 hover:shadow-xl hover:-translate-y-1 transition-transform duration-300">
            <div class="flex items-center space-x-4">
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6.375a.75.75 0 01.75.75v3.375a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75V7.5a.75.75 0 01.75-.75zM9 15h2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75V15.75A.75.75 0 019 15z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Manage All Vendors</h3>
                    <p class="mt-1 text-gray-600">View and update the status of all Vendors.</p>
                </div>
            </div>
        </a>
        <a href="{{ route('requests.index') }}" class="block bg-white rounded-lg shadow-lg p-8 hover:shadow-xl hover:-translate-y-1 transition-transform duration-300">
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.343-.026.69.023.962.166m-1.84 12.332a9 9 0 10-12.728 0M12 4.5A9 9 0 111.272 15M12 4.5v.008" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">My Purchase Requests</h3>
                    <p class="mt-1 text-gray-600">Submit new requests and view the status of your own.</p>
                </div>
            </div>
        </a>
    </div>

    @can('manage-users')
    <div class="mt-12 border-t-2 pt-8">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Manager Tools</h3>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Purchase Report Card -->
            <a href="{{ route('reports.purchases.index') }}" class="block bg-white rounded-lg shadow-lg p-8 hover:shadow-xl hover:-translate-y-1 transition-transform duration-300">
                <div class="flex items-center space-x-4">
                    <div class="bg-red-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 100 15 7.5 7.5 0 000-15zM21 21l-5.197-5.197" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Purchase Report</h3>
                        <p class="mt-1 text-gray-600">Filter, view, and export detailed purchase reports.</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('users.manage.index') }}" class="block bg-white rounded-lg shadow-lg p-8 hover:shadow-xl hover:-translate-y-1 transition-transform duration-300">
                <div class="flex items-center space-x-4">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-4.663c.11-.205.228-.409.354-.614a3.375 3.375 0 015.63 2.493z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">User Management</h3>
                        <p class="mt-1 text-gray-600">View all users and assign manager roles.</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('verifications.manage.index') }}" class="block bg-white rounded-lg shadow-lg p-8 hover:shadow-xl hover:-translate-y-1 transition-transform duration-300">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Verifications Management</h3>
                        <p class="mt-1 text-gray-600">View all Verifications request.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endcan
</div>
@endsection

