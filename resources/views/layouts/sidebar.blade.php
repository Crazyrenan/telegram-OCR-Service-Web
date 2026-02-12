<aside class="flex flex-col w-64 h-screen bg-primary-900 text-white transition-transform duration-300 border-r border-primary-800 fixed md:relative z-30"
     :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
    
    <div class="h-16 flex items-center px-6 bg-primary-800 border-b border-primary-700 shadow-sm shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-white flex items-center justify-center text-primary-900 font-bold">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
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

        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-primary-400 uppercase tracking-wider">OCR System</p>
        </div>

        <a href="{{ route('ocr.upload.form') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('ocr.upload.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
            <svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            Scan Dokumen
        </a>

        <a href="{{ route('search.form') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('search.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
            <svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            Cari Arsip
        </a>
        
        @can('manage-users')
        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-primary-400 uppercase tracking-wider">Manager Area</p>
        </div>

        <a href="{{ route('vendors.manage.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('vendors.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
            <svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
            Manage Vendors
        </a>

        <a href="{{ route('reports.purchases.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('reports.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
            <svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            Laporan Pembelian
        </a>

        <a href="{{ route('users.manage.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('users.*') ? 'bg-primary-800 text-white shadow-sm border-l-4 border-accent-500' : 'text-primary-100 hover:bg-primary-800 hover:text-white' }}">
            <svg class="w-5 h-5 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            Users & Roles
        </a>
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