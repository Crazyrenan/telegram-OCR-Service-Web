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
                    },
                    transitionProperty: {
                        'width': 'width'
                    },
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        /* Smooth transition for sidebar width */
        .sidebar-transition { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" 
      x-data="{ 
          sidebarOpen: false, 
          sidebarExpanded: localStorage.getItem('sidebarExpanded') === 'true' 
      }"
      x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebarExpanded', value))">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="flex flex-col h-screen bg-primary-900 text-white border-r border-primary-800 fixed md:relative z-30 sidebar-transition"
             :class="{
                'translate-x-0': sidebarOpen,
                '-translate-x-full': !sidebarOpen,
                'md:translate-x-0': true,
                'w-64': sidebarExpanded,
                'w-20': !sidebarExpanded
             }">
            
            <div class="h-16 flex items-center bg-primary-800 border-b border-primary-700 shadow-sm shrink-0 overflow-hidden px-4"
                 :class="sidebarExpanded ? 'justify-start gap-3' : 'justify-center'">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded bg-white flex items-center justify-center text-primary-900 font-bold shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="font-bold tracking-wide text-lg whitespace-nowrap transition-opacity duration-300"
                          x-show="sidebarExpanded" 
                          x-transition:enter="delay-100">
                        TelePortal
                    </span>
                </a>
            </div>

            <nav class="flex-1 py-6 px-3 space-y-2 overflow-y-auto overflow-x-hidden">
                
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors group relative overflow-hidden whitespace-nowrap
                   {{ request()->routeIs('dashboard') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}"
                   :class="!sidebarExpanded ? 'justify-center' : ''">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    <span x-show="sidebarExpanded" x-transition>Dashboard</span>
                    <div x-show="!sidebarExpanded" class="absolute left-14 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 pointer-events-none">Dashboard</div>
                </a>

                <a href="{{ route('requests.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors group relative overflow-hidden whitespace-nowrap
                   {{ request()->routeIs('requests.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}"
                   :class="!sidebarExpanded ? 'justify-center' : ''">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span x-show="sidebarExpanded" x-transition>Requests Saya</span>
                    <div x-show="!sidebarExpanded" class="absolute left-14 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 pointer-events-none">Requests</div>
                </a>

                <a href="{{ route('services.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors group relative overflow-hidden whitespace-nowrap
                   {{ request()->routeIs('services.index') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}"
                   :class="!sidebarExpanded ? 'justify-center' : ''">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    <span x-show="sidebarExpanded" x-transition>Buat Request</span>
                    <div x-show="!sidebarExpanded" class="absolute left-14 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 pointer-events-none">Buat Baru</div>
                </a>

                <div class="pt-4 pb-2" x-show="sidebarExpanded" x-transition>
                    <p class="px-3 text-xs font-semibold text-primary-400 uppercase tracking-wider">OCR System</p>
                </div>
                <div class="pt-4 pb-2 border-t border-primary-800 mx-2" x-show="!sidebarExpanded"></div>

                <a href="{{ route('ocr.upload.form') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors group relative overflow-hidden whitespace-nowrap
                   {{ request()->routeIs('ocr.upload.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}"
                   :class="!sidebarExpanded ? 'justify-center' : ''">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    <span x-show="sidebarExpanded" x-transition>Scan Dokumen</span>
                    <div x-show="!sidebarExpanded" class="absolute left-14 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 pointer-events-none">Scan</div>
                </a>

                <a href="{{ route('search.form') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors group relative overflow-hidden whitespace-nowrap
                   {{ request()->routeIs('search.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}"
                   :class="!sidebarExpanded ? 'justify-center' : ''">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <span x-show="sidebarExpanded" x-transition>Cari Arsip</span>
                    <div x-show="!sidebarExpanded" class="absolute left-14 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 pointer-events-none">Cari</div>
                </a>
                
                @can('manage-users')
                <div class="pt-4 pb-2" x-show="sidebarExpanded" x-transition>
                    <p class="px-3 text-xs font-semibold text-primary-400 uppercase tracking-wider">Manager</p>
                </div>
                <div class="pt-4 pb-2 border-t border-primary-800 mx-2" x-show="!sidebarExpanded"></div>

                <a href="{{ route('vendors.manage.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors group relative overflow-hidden whitespace-nowrap
                   {{ request()->routeIs('vendors.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}"
                   :class="!sidebarExpanded ? 'justify-center' : ''">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    <span x-show="sidebarExpanded" x-transition>Vendors</span>
                    <div x-show="!sidebarExpanded" class="absolute left-14 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 pointer-events-none">Vendors</div>
                </a>

                <a href="{{ route('reports.purchases.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors group relative overflow-hidden whitespace-nowrap
                   {{ request()->routeIs('reports.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}"
                   :class="!sidebarExpanded ? 'justify-center' : ''">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span x-show="sidebarExpanded" x-transition>Reports</span>
                    <div x-show="!sidebarExpanded" class="absolute left-14 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 pointer-events-none">Reports</div>
                </a>

                <a href="{{ route('users.manage.index') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors group relative overflow-hidden whitespace-nowrap
                   {{ request()->routeIs('users.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}"
                   :class="!sidebarExpanded ? 'justify-center' : ''">
                    <svg class="w-6 h-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <span x-show="sidebarExpanded" x-transition>Users</span>
                    <div x-show="!sidebarExpanded" class="absolute left-14 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 pointer-events-none">Users</div>
                </a>
                @endcan
            </nav>

            <div class="hidden md:flex p-4 border-t border-primary-800 justify-end">
                <button @click="sidebarExpanded = !sidebarExpanded" class="p-1 rounded-md hover:bg-primary-800 text-primary-200 hover:text-white transition-colors focus:outline-none">
                    <svg class="w-6 h-6 transition-transform duration-300" :class="sidebarExpanded ? 'rotate-0' : 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <div class="p-4 border-t border-primary-800 bg-primary-900 shrink-0 overflow-hidden">
                <div class="flex items-center gap-3" :class="!sidebarExpanded ? 'justify-center' : ''">
                    <div class="w-9 h-9 rounded-full bg-primary-700 flex items-center justify-center text-sm font-bold border border-primary-600 text-white shrink-0">
                        @auth {{ substr(Auth::user()->name, 0, 1) }} @else G @endauth
                    </div>
                    <div class="flex-1 min-w-0" x-show="sidebarExpanded" x-transition>
                        @auth
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-xs text-primary-300 hover:text-white transition-colors text-left w-full">
                                    Sign Out
                                </button>
                            </form>
                        @else
                             <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:underline">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </aside>
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 md:hidden" style="display: none;"></div>

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            <header class="bg-white border-b border-gray-200 flex items-center justify-between px-6 py-4 md:hidden shrink-0">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <span class="font-bold text-gray-800">TelePortal</span>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-6 lg:p-8">
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-md bg-green-50 text-green-700 border border-green-200 shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        {{ session('status') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="mb-6 p-4 rounded-md bg-red-50 text-red-700 border border-red-200 shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>
    
</body>
</html>