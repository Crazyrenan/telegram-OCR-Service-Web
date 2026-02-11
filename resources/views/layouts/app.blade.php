<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">
        
        <div class="flex h-screen overflow-hidden">
            @include('layouts.sidebar')

            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 md:hidden" style="display: none;"></div>

            <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
                
                <header class="bg-white border-b border-gray-200 flex items-center justify-between px-6 py-4 md:hidden">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        </button>
                        <span class="font-bold text-gray-800">OCR Service</span>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto p-4 md:p-8">
                    @if (session('status'))
                        <div class="mb-6 p-4 rounded-xl bg-accent-500/10 border border-accent-500/20 text-accent-600 font-medium">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>