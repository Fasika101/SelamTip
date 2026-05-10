@extends('layouts.admin')

@section('title', $beggar->name)
@section('page-title', $beggar->name . "'s Profile")

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left: Profile card + QR -->
    <div class="space-y-5">
        <!-- Profile card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-24 bg-gradient-to-r from-amber-400 to-orange-500 relative">
                <div class="absolute bottom-0 left-0 right-0 h-0.5 eth-stripe"></div>
            </div>
            <div class="px-5 pb-5">
                <div class="flex items-end gap-3 -mt-10 mb-4">
                    <img src="{{ $beggar->photo_url }}"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($beggar->name) }}&background=b45309&color=fff&size=80'"
                         class="w-20 h-20 rounded-2xl border-4 border-white shadow-lg object-cover">
                    <div class="pb-1">
                        @if($beggar->is_active)
                            <span class="bg-green-50 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full border border-green-100">● Active</span>
                        @else
                            <span class="bg-red-50 text-red-600 text-xs font-semibold px-2.5 py-1 rounded-full border border-red-100">● Inactive</span>
                        @endif
                    </div>
                </div>

                <h2 class="text-xl font-bold text-gray-900">{{ $beggar->name }}</h2>
                <p class="text-sm text-gray-500 flex items-center gap-1 mt-0.5">🇪🇹 {{ $beggar->city }}, Ethiopia</p>
                @if($beggar->bio)
                    <p class="text-gray-600 text-sm mt-3 leading-relaxed">{{ $beggar->bio }}</p>
                @endif

                <div class="mt-4 bg-amber-50 rounded-xl px-3 py-2.5 border border-amber-100">
                    <p class="text-xs text-gray-500 mb-0.5">Unique Code</p>
                    <p class="font-mono font-bold text-brand-800">{{ $beggar->unique_code }}</p>
                </div>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('admin.beggars.edit', $beggar) }}"
                       class="flex-1 text-center py-2.5 bg-brand-50 text-brand-800 rounded-xl text-sm font-semibold hover:bg-brand-100 transition-colors border border-brand-100">
                        Edit Profile
                    </a>
                    <a href="{{ route('tip.show', $beggar->unique_code) }}" target="_blank"
                       class="flex-1 text-center py-2.5 bg-gray-50 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-100 transition-colors border border-gray-100">
                        View Public
                    </a>
                </div>
            </div>
        </div>

        <!-- QR Code card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                QR Code
            </h3>

            <div class="bg-amber-50 rounded-2xl p-4 flex justify-center border border-amber-100">
                {!! $qrCode !!}
            </div>

            <p class="text-xs text-gray-400 text-center mt-3 mb-4">Scan to open tip page</p>

            <a href="{{ route('admin.beggars.qr', $beggar) }}"
               class="w-full flex items-center justify-center gap-2 py-3 bg-brand-800 hover:bg-brand-700 text-white rounded-xl font-semibold text-sm transition-colors shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download QR Code
            </a>
        </div>
    </div>

    <!-- Right: Tips history -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-lg">Tips History</h3>
                <p class="text-sm text-gray-500 mt-0.5">
                    Total received: <span class="font-bold text-brand-800">{{ number_format($beggar->totalTips(), 0) }} ETB</span>
                </p>
            </div>

            @if($tips->isEmpty())
                <div class="text-center py-16 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="font-medium">No tips yet</p>
                    <p class="text-sm mt-1">Share the QR code to start receiving tips.</p>
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($tips as $tip)
                    <div class="px-6 py-4 flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 border border-green-100">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800">{{ number_format($tip->amount, 0) }} ETB</p>
                            <p class="text-xs text-gray-400 font-mono">{{ $tip->phone }} · {{ $tip->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="bg-amber-50 text-brand-800 text-xs font-mono font-bold px-2.5 py-1 rounded-lg border border-amber-100">
                                {{ $tip->lotto_number }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
