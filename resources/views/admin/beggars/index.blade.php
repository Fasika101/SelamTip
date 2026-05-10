@extends('layouts.admin')

@section('title', 'All Profiles')
@section('page-title', 'All Profiles')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">{{ $beggars->count() }} profile(s) registered</p>
    <a href="{{ route('admin.beggars.create') }}"
       class="bg-brand-800 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-colors flex items-center gap-2 shadow-md">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Profile
    </a>
</div>

@if($beggars->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 text-center text-gray-400">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <p class="font-semibold text-lg">No profiles yet</p>
        <p class="text-sm mt-1">Add the first profile to get started.</p>
        <a href="{{ route('admin.beggars.create') }}" class="mt-4 inline-block bg-brand-800 text-white px-6 py-3 rounded-xl font-semibold text-sm hover:bg-brand-700 transition-colors">Create Profile</a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($beggars as $beggar)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            <!-- Card header -->
            <div class="h-20 bg-gradient-to-r from-amber-400 to-orange-400 relative">
                <div class="absolute bottom-0 left-0 right-0 h-0.5 eth-stripe"></div>
            </div>

            <!-- Profile info -->
            <div class="px-5 pb-5">
                <!-- Photo + status badge row -->
                <div class="flex items-start justify-between -mt-8 mb-3">
                    <img src="{{ $beggar->photo_url }}"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($beggar->name) }}&background=b45309&color=fff&size=80'"
                         class="w-16 h-16 rounded-2xl border-4 border-white shadow-md object-cover flex-shrink-0">
                    <div class="mt-9">
                        @if($beggar->is_active)
                            <span class="bg-green-50 text-green-700 text-xs font-semibold px-2 py-1 rounded-full border border-green-100">Active</span>
                        @else
                            <span class="bg-gray-50 text-gray-500 text-xs font-semibold px-2 py-1 rounded-full border border-gray-100">Inactive</span>
                        @endif
                    </div>
                </div>
                <!-- Name + city below photo -->
                <div class="mb-3">
                    <h3 class="font-bold text-gray-900 text-base">{{ $beggar->name }}</h3>
                    <p class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">🇪🇹 {{ $beggar->city }}</p>
                </div>

                <!-- Stats row -->
                <div class="flex gap-3 mb-4">
                    <div class="flex-1 bg-amber-50 rounded-xl px-3 py-2 text-center border border-amber-100">
                        <p class="text-xs text-gray-500 font-medium">Tips</p>
                        <p class="font-black text-brand-800 text-lg">{{ $beggar->paid_tips_count ?? 0 }}</p>
                    </div>
                    <div class="flex-1 bg-amber-50 rounded-xl px-3 py-2 text-center border border-amber-100">
                        <p class="text-xs text-gray-500 font-medium">Received</p>
                        <p class="font-black text-brand-800 text-lg">{{ number_format($beggar->total_received ?? 0, 0) }}<span class="text-xs font-normal ml-0.5">ETB</span></p>
                    </div>
                </div>

                <!-- Code badge -->
                <div class="bg-gray-50 rounded-xl px-3 py-2 flex items-center gap-2 mb-4 border border-gray-100">
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    <span class="font-mono text-sm text-gray-600 font-semibold flex-1">{{ $beggar->unique_code }}</span>
                    <a href="{{ route('admin.beggars.qr', $beggar) }}" class="text-xs text-brand-700 font-semibold hover:text-brand-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        QR
                    </a>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.beggars.show', $beggar) }}"
                       class="flex-1 text-center py-2.5 bg-brand-50 text-brand-800 rounded-xl text-sm font-semibold hover:bg-brand-100 transition-colors border border-brand-100">
                        View
                    </a>
                    <a href="{{ route('admin.beggars.edit', $beggar) }}"
                       class="flex-1 text-center py-2.5 bg-gray-50 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-100 transition-colors border border-gray-100">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.beggars.destroy', $beggar) }}"
                          onsubmit="return confirm('Delete {{ $beggar->name }}? This cannot be undone.')"
                          class="flex-shrink-0">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="p-2.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors border border-transparent hover:border-red-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
