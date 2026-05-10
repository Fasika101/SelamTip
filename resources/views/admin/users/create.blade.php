@extends('layouts.admin')

@section('title', 'New User')
@section('page-title', 'Create New User')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-brand-800 to-brand-600 px-6 py-5">
            <h2 class="text-white font-bold text-lg">Add Admin User</h2>
            <p class="text-brand-200 text-sm mt-0.5">Create a new account to access the admin panel.</p>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       placeholder="e.g. Abebe Tadesse"
                       class="w-full px-4 py-3 border rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all text-sm
                           {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-400">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="user@example.com"
                       class="w-full px-4 py-3 border rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all text-sm
                           {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Role <span class="text-red-400">*</span></label>
                <div class="grid grid-cols-2 gap-3" x-data="{ role: '{{ old('role', 'manager') }}' }">
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="admin" x-model="role" class="sr-only">
                        <div :class="role === 'admin' ? 'border-brand-700 bg-brand-50 ring-2 ring-brand-600' : 'border-gray-200 bg-gray-50 hover:border-gray-300'"
                             class="rounded-xl border-2 p-4 transition-all text-center">
                            <div class="text-2xl mb-1">👑</div>
                            <p class="font-bold text-sm text-gray-800">Admin</p>
                            <p class="text-xs text-gray-500 mt-0.5">Full access · manage users</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="manager" x-model="role" class="sr-only">
                        <div :class="role === 'manager' ? 'border-amber-500 bg-amber-50 ring-2 ring-amber-400' : 'border-gray-200 bg-gray-50 hover:border-gray-300'"
                             class="rounded-xl border-2 p-4 transition-all text-center">
                            <div class="text-2xl mb-1">🛠</div>
                            <p class="font-bold text-sm text-gray-800">Manager</p>
                            <p class="text-xs text-gray-500 mt-0.5">Manage profiles · view tips</p>
                        </div>
                    </label>
                </div>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div x-data="{ show: false }">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-400">*</span></label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" name="password" required
                           placeholder="Minimum 8 characters"
                           class="w-full px-4 py-3 pr-12 border rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all text-sm
                               {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                    <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password <span class="text-red-400">*</span></label>
                <input type="password" name="password_confirmation" required placeholder="Repeat password"
                       class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all text-sm">
            </div>

            <!-- Submit -->
            <div class="pt-2 flex gap-3">
                <a href="{{ route('admin.users.index') }}"
                   class="flex-1 text-center py-3 border border-gray-200 text-gray-600 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="flex-1 py-3 bg-brand-800 hover:bg-brand-700 text-white rounded-xl font-bold text-sm transition-colors shadow-md">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
