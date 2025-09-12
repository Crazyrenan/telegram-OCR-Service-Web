@extends('layout')

@section('content')
<div class="px-4 py-8">
    <div class="bg-white rounded-lg shadow-xl p-8 md:p-12 text-center">
        
        <!-- Hero Icon -->
        <div class="w-24 h-24 mx-auto bg-blue-100 rounded-full flex items-center justify-center">
            <svg class="h-12 w-12 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
        </div>

        <!-- Main Heading -->
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-6">
            Welcome to the TelePortal
        </h1>

        <!-- Subheading -->
        <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
            Pusat terpadu untuk mengelola data aplikasi sekaligus memperoleh wawasan real-time melalui Bot Telegram yang terintegrasi.
        </p>

        <!-- Call to Action Buttons -->
        <div class="mt-8 flex justify-center items-center space-x-4">
            <!-- This link now correctly points to the login page -->
            <a href="{{ route('login') }}" class="bg-white text-gray-700 font-bold py-3 px-6 rounded-lg border-2 border-gray-300 hover:bg-gray-100 transition duration-300">
                Login
            </a>
            <!-- This button now links directly to the purchase requests page for testing. -->
            <a href="{{ route('requests.index') }}" class="bg-blue-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-600 transition duration-300">
                Get Started
            </a>
        </div>

    </div>

    <!-- Feature Section -->
    <div class="mt-16 grid md:grid-cols-3 gap-8 text-left">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold text-gray-800">Real-Time Alerts</h3>
            <p class="mt-2 text-gray-600">Submit purchase requests and get instant approval notifications sent directly to your Telegram.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold text-gray-800">On-Demand Reports</h3>
            <p class="mt-2 text-gray-600">Use simple commands in your bot to pull detailed, formatted reports from your application database anytime.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold text-gray-800">Automated Briefings</h3>
            <p class="mt-2 text-gray-600">Receive scheduled summaries of key metrics automatically, keeping you informed without any effort.</p>
        </div>
    </div>
</div>
@endsection

