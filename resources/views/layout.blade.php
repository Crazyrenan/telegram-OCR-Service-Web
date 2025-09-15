<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Telegram Bot Web Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .form-input { border-color: #d1d5db; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); }
        .form-input:focus { --tw-ring-color: rgb(59 130 246 / 0.5); border-color: #3b82f6; }
        .btn-primary { background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; transition: background-color 0.2s ease-in-out; }
        .btn-primary:hover { background-color: #2563eb; }
        .btn-secondary { background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; transition: background-color 0.2s ease-in-out; }
        .btn-secondary:hover { background-color: #4b5563; }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div x-data="{ open: false, profileOpen: false }" class="min-h-screen">
        <!-- Navigation Bar -->
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center space-x-2">
                            <svg class="h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            <span class="font-bold text-xl text-gray-800">TelePortal</span>
                        </a>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="{{ route('home') }}" class="text-gray-600 hover:bg-gray-100 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:bg-gray-100 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                                <a href="{{ route('requests.index') }}" class="text-gray-600 hover:bg-gray-100 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">My Requests</a>
                                @can('manage-users')
                                    <a href="{{ route('users.manage.index') }}" class="text-gray-600 bg-red-100 text-red-700 font-bold px-3 py-2 rounded-md text-sm">User Management</a>
                                @endcan
                            @endauth
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            @auth
                                <div class="ml-3 relative" @click.away="profileOpen = false">
                                    <div>
                                        <button @click="profileOpen = !profileOpen" type="button" class="max-w-xs bg-gray-100 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                            <span class="sr-only">Open user menu</span>
                                            <div class="px-3 py-2">{{ Auth::user()->name }}</div>
                                        </button>
                                    </div>
                                    <div x-show="profileOpen" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Your Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Sign out</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:bg-gray-100 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                                <a href="{{ route('register') }}" class="bg-blue-500 text-white hover:bg-blue-600 px-3 py-2 rounded-md text-sm font-medium">Register</a>
                            @endauth
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <button @click="open = !open" type="button" class="bg-gray-100 inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-200 focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg :class="{'hidden': open, 'block': !open }" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                            <svg :class="{'block': open, 'hidden': !open }" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                </div>
            </div>
            <div x-show="open" class="md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Home</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                        <a href="{{ route('requests.index') }}" class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">My Requests</a>
                        @can('manage-users')
                            <a href="{{ route('users.manage.index') }}" class="text-gray-600 bg-red-100 text-red-700 font-bold block px-3 py-2 rounded-md text-base">User Management</a>
                        @endcan
                    @endauth
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="px-2 space-y-1">
                        @auth
                             <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Your Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Sign out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Login</a>
                            <a href="{{ route('register') }}" class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>

