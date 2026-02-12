<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TelePortal') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: {
                            50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0', 300: '#86efac', 
                            400: '#4ade80', 500: '#22c55e', 600: '#16a34a', 700: '#15803d', 
                            800: '#166534', 900: '#14532d'
                        },
                        accent: {
                            500: '#eab308', 600: '#ca8a04'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="flex flex-col w-64 h-screen bg-primary-900 text-white transition-transform duration-300 border-r border-primary-800 fixed md:relative z-30"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            
            <div class="h-16 flex items-center px-6 bg-primary-800 border-b border-primary-700 shadow-sm shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-white flex items-center justify-center text-primary-900 font-bold">
                        T
                    </div>
                    <span class="font-bold tracking-wide text-lg">TelePortal</span>
                </a>
            </div>

            <nav class="flex-1 py-6 px-3 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Dashboard
                </a>

                <a href="{{ route('requests.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('requests.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Requests Saya
                </a>

                <a href="{{ route('services.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('services.index') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Buat Request Baru
                </a>

                <div class="pt-4 pb-2"><p class="px-3 text-xs font-semibold text-primary-400 uppercase tracking-wider">OCR System</p></div>

                <a href="{{ route('ocr.upload.form') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('ocr.upload.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Scan Dokumen
                </a>

                <a href="{{ route('search.form') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('search.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
                    <svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    Cari Arsip
                </a>
                
                @can('manage-users')
                <div class="pt-4 pb-2"><p class="px-3 text-xs font-semibold text-primary-400 uppercase tracking-wider">Manager Area</p></div>
                <a href="{{ route('vendors.manage.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('vendors.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}"><svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>Manage Vendors</a>
                <a href="{{ route('reports.purchases.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('reports.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}"><svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>Laporan Pembelian</a>
                <a href="{{ route('users.manage.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('users.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}"><svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>Users & Roles</a>
                @endcan
            </nav>

            <div class="p-4 border-t border-primary-800 bg-primary-900 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-primary-700 flex items-center justify-center text-sm font-bold border border-primary-600 text-white">
                        @auth {{ substr(Auth::user()->name, 0, 1) }} @else G @endauth
                    </div>
                    <div class="flex-1 min-w-0">
                        @auth
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-xs text-primary-300 hover:text-white transition-colors text-left w-full">Sign Out</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            <header class="bg-white border-b border-gray-200 flex items-center justify-between px-6 py-4 md:hidden shrink-0">
                <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <span class="font-bold text-gray-800">TelePortal</span>
            </header>

            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-6 lg:p-8">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
        
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 md:hidden" style="display: none;"></div>
    </div>
</body>
</html>