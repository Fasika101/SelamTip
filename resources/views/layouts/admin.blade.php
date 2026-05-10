<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — SelemaTip</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#fffbeb', 100: '#fef3c7', 200: '#fde68a',
                            300: '#fcd34d', 400: '#fbbf24', 500: '#f59e0b',
                            600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f',
                        },
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-brand-900 text-white flex flex-col shadow-2xl flex-shrink-0">
        <div class="p-6 border-b border-brand-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-400 rounded-xl flex items-center justify-center text-brand-900 font-black text-lg">S</div>
                <div>
                    <div class="font-bold text-lg leading-none">SelemaTip</div>
                    <div class="text-brand-300 text-xs mt-0.5">Admin Panel</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-brand-100 hover:bg-brand-700 hover:text-white transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-brand-700 text-white' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.beggars.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-brand-100 hover:bg-brand-700 hover:text-white transition-all {{ request()->routeIs('admin.beggars.*') ? 'bg-brand-700 text-white' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                Profiles
            </a>
            <a href="{{ route('admin.beggars.create') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-brand-100 hover:bg-brand-700 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Profile
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-brand-100 hover:bg-brand-700 hover:text-white transition-all {{ request()->routeIs('admin.users.*') ? 'bg-brand-700 text-white' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Users
            </a>
            @endif
        </nav>

        <div class="p-4 border-t border-brand-700">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-400 flex items-center justify-center font-black text-brand-900 text-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-white text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                    <p class="text-brand-400 text-xs truncate">{{ auth()->user()->isAdmin() ? '👑 Admin' : '🛠 Manager' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top bar -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <h1 class="text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500 hidden sm:block">SelemaTip Admin</span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 px-3 py-2 rounded-xl hover:bg-red-50 transition-all border border-transparent hover:border-red-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                     class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
