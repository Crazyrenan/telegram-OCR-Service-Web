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

    <!-- Quick Action Cards -->
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Manage Purchases Card -->
        <a href="{{ route('purchases.manage.index') }}" class="block bg-white rounded-lg shadow-lg p-8 hover:shadow-xl hover:-translate-y-1 transition-transform duration-300">
            <div class="flex items-center space-x-4">
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Manage All Purchases</h3>
                    <p class="mt-1 text-gray-600">View and update the status of all company purchases.</p>
                </div>
            </div>
        </a>

        <!-- My Purchase Requests Card -->
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
</div>
@endsection

