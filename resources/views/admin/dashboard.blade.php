@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <!-- Total profiles -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-14 h-14 bg-brand-50 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg class="w-7 h-7 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Profiles</p>
            <p class="text-3xl font-black text-gray-900">{{ $totalBeggars }}</p>
        </div>
    </div>

    <!-- Total tips -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Successful Tips</p>
            <p class="text-3xl font-black text-gray-900">{{ $totalTips }}</p>
        </div>
    </div>

    <!-- Total amount -->
    <div class="bg-gradient-to-br from-brand-800 to-brand-600 rounded-2xl p-6 shadow-sm flex items-center gap-4">
        <div class="w-14 h-14 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-sm text-amber-200 font-medium">Total Collected</p>
            <p class="text-3xl font-black text-white">{{ number_format($totalAmount, 0) }} <span class="text-lg font-semibold text-amber-200">ETB</span></p>
        </div>
    </div>
</div>

<!-- Recent tips table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-bold text-gray-900 text-lg">Recent Tips</h2>
        <a href="{{ route('admin.beggars.create') }}" class="text-sm bg-brand-800 text-white px-4 py-2 rounded-xl font-medium hover:bg-brand-700 transition-colors">+ Add Profile</a>
    </div>

    @if($recentTips->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="font-medium">No tips yet</p>
            <p class="text-sm mt-1">Create a profile and share the QR code to get started.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-6 py-3 text-left">Recipient</th>
                        <th class="px-6 py-3 text-left">Amount</th>
                        <th class="px-6 py-3 text-left">Phone</th>
                        <th class="px-6 py-3 text-left">Lotto #</th>
                        <th class="px-6 py-3 text-left">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentTips as $tip)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $tip->beggar->photo_url }}"
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($tip->beggar->name) }}&background=b45309&color=fff&size=40'"
                                     class="w-9 h-9 rounded-xl object-cover flex-shrink-0">
                                <span class="font-medium text-gray-800">{{ $tip->beggar->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-brand-800">{{ number_format($tip->amount, 0) }} ETB</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm font-mono">{{ $tip->phone }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-amber-50 text-brand-800 text-xs font-mono font-bold px-2.5 py-1 rounded-lg border border-amber-100">
                                {{ $tip->lotto_number }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-400 text-sm">{{ $tip->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
