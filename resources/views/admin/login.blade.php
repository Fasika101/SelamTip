<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .eth-stripe { background: linear-gradient(90deg, #078930 33.33%, #FCDD09 33.33% 66.66%, #DA121A 66.66%); }
        @keyframes slideUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
        .slide-up { animation: slideUp 0.5s ease-out forwards; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-900 via-amber-800 to-orange-900 flex flex-col">

    <!-- Ethiopian flag stripe -->
    <div class="eth-stripe h-1.5 w-full flex-shrink-0"></div>

    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-5 pointer-events-none"
         style="background-image: radial-gradient(circle at 25px 25px, #fff 1.5px, transparent 0); background-size: 50px 50px;"></div>

    <div class="flex-1 flex items-center justify-center px-4 py-16 relative">
        <div class="w-full max-w-sm slide-up">

            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-amber-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl">
                    <span class="text-amber-900 font-black text-3xl">S</span>
                </div>
                <h1 class="text-white font-black text-3xl">{{ config('app.name') }}</h1>
                <p class="text-amber-300 text-sm mt-1">Admin Panel · 🇪🇹 Ethiopia</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="px-8 py-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-1">Welcome back</h2>
                    <p class="text-gray-500 text-sm mb-6">Enter your admin password to continue.</p>

                    <form method="POST" action="{{ route('admin.login.post') }}" x-data="{ showPwd: false }">
                        @csrf

                        @if(session('error'))
                            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                   placeholder="admin@example.com"
                                   class="w-full px-4 py-3.5 border rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all text-sm
                                       {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                            @error('email')
                                <div class="mt-2 flex items-center gap-1.5 text-red-600 text-sm">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <input :type="showPwd ? 'text' : 'password'" name="password" required
                                       placeholder="Your password"
                                       class="w-full px-4 py-3.5 pr-12 border rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all text-sm
                                           {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                                <button type="button" @click="showPwd = !showPwd"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                                    <svg x-show="!showPwd" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showPwd" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Remember me -->
                        <div class="flex items-center gap-2 mb-6">
                            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-300 text-amber-600 focus:ring-amber-400">
                            <label for="remember" class="text-sm text-gray-600">Keep me logged in</label>
                        </div>

                        <button type="submit"
                                class="w-full py-4 bg-gradient-to-r from-amber-800 to-amber-700 hover:from-amber-700 hover:to-amber-600 text-white rounded-xl font-bold text-sm transition-all duration-200 shadow-lg hover:shadow-xl">
                            Sign In
                        </button>
                    </form>
                </div>

                <!-- Footer strip -->
                <div class="eth-stripe h-1"></div>
            </div>

            <p class="text-center text-amber-400 text-xs mt-6">
                {{ config('app.name') }} · Helping those in need 🇪🇹
            </p>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
