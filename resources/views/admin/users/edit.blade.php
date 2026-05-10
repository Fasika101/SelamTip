@extends('layouts.admin')

@section('title', 'Edit ' . $user->name)
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-brand-800 to-brand-600 px-6 py-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl {{ $user->isAdmin() ? 'bg-amber-400' : 'bg-amber-300' }} flex items-center justify-center font-black text-brand-900 text-xl flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-white font-bold text-lg leading-none">{{ $user->name }}</h2>
                <p class="text-brand-200 text-sm mt-0.5">{{ $user->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6 space-y-5">
            @csrf @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all text-sm">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all text-sm">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                <div class="grid grid-cols-2 gap-3" x-data="{ role: '{{ old('role', $user->role) }}' }">
                    <label class="cursor-pointer {{ $user->id === auth()->id() ? 'opacity-50 pointer-events-none' : '' }}">
                        <input type="radio" name="role" value="admin" x-model="role" class="sr-only">
                        <div :class="role === 'admin' ? 'border-brand-700 bg-brand-50 ring-2 ring-brand-600' : 'border-gray-200 bg-gray-50 hover:border-gray-300'"
                             class="rounded-xl border-2 p-4 transition-all text-center">
                            <div class="text-2xl mb-1">👑</div>
                            <p class="font-bold text-sm text-gray-800">Admin</p>
                            <p class="text-xs text-gray-500 mt-0.5">Full access</p>
                        </div>
                    </label>
                    <label class="cursor-pointer {{ $user->id === auth()->id() ? 'opacity-50 pointer-events-none' : '' }}">
                        <input type="radio" name="role" value="manager" x-model="role" class="sr-only">
                        <div :class="role === 'manager' ? 'border-amber-500 bg-amber-50 ring-2 ring-amber-400' : 'border-gray-200 bg-gray-50 hover:border-gray-300'"
                             class="rounded-xl border-2 p-4 transition-all text-center">
                            <div class="text-2xl mb-1">🛠</div>
                            <p class="font-bold text-sm text-gray-800">Manager</p>
                            <p class="text-xs text-gray-500 mt-0.5">Manage profiles</p>
                        </div>
                    </label>
                </div>
                @if($user->id === auth()->id())
                    <p class="text-xs text-amber-600 mt-2">⚠ You cannot change your own role.</p>
                @endif
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Active toggle -->
            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-xl border border-gray-100">
                <div>
                    <p class="font-semibold text-gray-700 text-sm">Account Active</p>
                    <p class="text-xs text-gray-400 mt-0.5">Inactive users cannot log in</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer {{ $user->id === auth()->id() ? 'opacity-50 pointer-events-none' : '' }}">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                           {{ $user->is_active ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-700"></div>
                </label>
            </div>

            <!-- New Password (optional) -->
            <div x-data="{ show: false, change: false }">
                <div class="flex items-center justify-between mb-2">
                    <label class="text-sm font-semibold text-gray-700">Password</label>
                    <button type="button" @click="change = !change"
                            class="text-xs text-brand-700 font-semibold hover:underline">
                        <span x-text="change ? 'Cancel' : 'Change password'"></span>
                    </button>
                </div>
                <div x-show="change" x-transition class="space-y-3">
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password"
                               placeholder="New password (min 8 chars)"
                               class="w-full px-4 py-3 pr-12 border border-gray-200 bg-gray-50 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all text-sm">
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    <input type="password" name="password_confirmation" placeholder="Confirm new password"
                           class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm">
                    @error('password') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
                <div x-show="!change">
                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-gray-400 text-sm">••••••••</div>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-2 flex gap-3">
                <a href="{{ route('admin.users.index') }}"
                   class="flex-1 text-center py-3 border border-gray-200 text-gray-600 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="flex-1 py-3 bg-brand-800 hover:bg-brand-700 text-white rounded-xl font-bold text-sm transition-colors shadow-md">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
