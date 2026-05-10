@extends('layouts.app')

@section('title', 'Tip ' . $beggar->name . ' — ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-amber-100 flex flex-col">

    <!-- Ethiopian flag stripe at top -->
    <div class="eth-stripe h-1.5 w-full flex-shrink-0"></div>

    <!-- Header -->
    <div class="text-center pt-6 pb-2 px-4">
        <span class="inline-flex items-center gap-2 text-brand-800 font-bold text-lg tracking-tight">
            <span class="text-2xl">🤲</span> {{ config('app.name') }}
        </span>
    </div>

    <!-- Main card -->
    <div class="flex-1 flex items-start justify-center px-4 py-4 pb-10">
        <div class="w-full max-w-sm animate-slide-up">

            <!-- Profile card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

                <!-- Cover gradient -->
                <div class="h-28 bg-gradient-to-br from-amber-400 via-orange-400 to-amber-600 relative">
                    <div class="absolute inset-0 opacity-20"
                         style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23fff\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'20\' cy=\'20\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E')">
                    </div>
                    <!-- Ethiopian flag colors at bottom of cover -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 eth-stripe"></div>
                </div>

                <!-- Avatar -->
                <div class="flex justify-center -mt-14 relative z-10 px-6">
                    <div class="relative">
                        <img src="{{ $beggar->photo_url }}"
                             alt="{{ $beggar->name }}"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($beggar->name) }}&background=b45309&color=fff&size=128'"
                             class="w-28 h-28 rounded-2xl border-4 border-white shadow-xl object-cover">
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-400 rounded-full border-2 border-white"></div>
                    </div>
                </div>

                <!-- Profile info -->
                <div class="px-6 pt-3 pb-5 text-center">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $beggar->name }}</h1>
                    <div class="flex items-center justify-center gap-1.5 mt-1">
                        <span class="text-xl">🇪🇹</span>
                        <span class="text-sm text-gray-500 font-medium">{{ $beggar->city }}, Ethiopia</span>
                    </div>
                    @if($beggar->bio)
                        <p class="text-gray-600 text-sm mt-2 leading-relaxed">{{ $beggar->bio }}</p>
                    @endif
                </div>

                <!-- Divider -->
                <div class="mx-6 h-px bg-gradient-to-r from-transparent via-amber-200 to-transparent"></div>

                <!-- Tip form -->
                <div class="px-6 pt-5 pb-6" x-data="{
                    amount: '',
                    customAmount: '',
                    phone: '',
                    error: '',
                    loading: false,
                    setAmount(val) {
                        this.amount = val;
                        this.customAmount = '';
                    },
                    get finalAmount() {
                        return this.customAmount || this.amount;
                    },
                    validate() {
                        if (!this.finalAmount || this.finalAmount < 5) {
                            this.error = 'Please select or enter an amount (minimum 5 ETB).';
                            return false;
                        }
                        if (!this.phone || this.phone.length < 9) {
                            this.error = 'Please enter a valid Ethiopian phone number.';
                            return false;
                        }
                        this.error = '';
                        return true;
                    }
                }">
                    <p class="text-sm font-semibold text-gray-700 mb-3 text-center uppercase tracking-wide">Choose an amount</p>

                    <!-- Preset amounts -->
                    <div class="grid grid-cols-4 gap-2 mb-4">
                        @foreach([10, 20, 50, 100] as $preset)
                        <button type="button"
                                @click="setAmount({{ $preset }})"
                                :class="amount == {{ $preset }} && !customAmount ? 'bg-brand-800 text-white shadow-lg scale-105 ring-2 ring-brand-600' : 'bg-amber-50 text-brand-800 border border-amber-200 hover:bg-amber-100'"
                                class="py-3 rounded-2xl font-bold text-sm transition-all duration-200 focus:outline-none">
                            {{ $preset }}<span class="text-xs font-normal block -mt-0.5">ETB</span>
                        </button>
                        @endforeach
                    </div>

                    <!-- Custom amount -->
                    <div class="relative mb-5">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">ETB</span>
                        <input type="number"
                               x-model="customAmount"
                               @input="amount = ''"
                               placeholder="Or enter custom amount..."
                               min="5"
                               class="w-full pl-14 pr-4 py-3.5 border border-gray-200 rounded-2xl text-gray-800 font-medium focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent bg-gray-50 transition-all placeholder-gray-400 text-sm">
                    </div>

                    <!-- Phone input -->
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Your Phone Number</label>
                        <div class="flex rounded-2xl border border-gray-200 overflow-hidden focus-within:ring-2 focus-within:ring-amber-400 focus-within:border-transparent bg-gray-50 transition-all">
                            <!-- Country flag prefix -->
                            <div class="flex items-center gap-2 px-4 bg-amber-50 border-r border-gray-200 flex-shrink-0">
                                <span class="text-xl">🇪🇹</span>
                                <span class="text-sm font-semibold text-gray-600 whitespace-nowrap">+251</span>
                            </div>
                            <input type="tel"
                                   x-model="phone"
                                   placeholder="9x xxx xxxx"
                                   maxlength="10"
                                   class="flex-1 px-4 py-3.5 bg-gray-50 focus:outline-none text-gray-800 font-medium text-sm placeholder-gray-400 min-w-0">
                        </div>
                        <p class="text-xs text-gray-400 mt-1.5 pl-1">Enter your number without the leading 0</p>
                    </div>

                    <!-- Error message -->
                    <div x-show="error" x-transition class="mb-4 bg-red-50 border border-red-200 rounded-xl px-4 py-2.5 text-sm text-red-700 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span x-text="error"></span>
                    </div>

                    @if(session('error'))
                        <div class="mb-4 bg-red-50 border border-red-200 rounded-xl px-4 py-2.5 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Pay button -->
                    <form method="POST" action="{{ route('tip.initiate', $beggar->unique_code) }}"
                          @submit.prevent="if(validate()) { loading = true; $el.submit(); }">
                        @csrf
                        <input type="hidden" name="amount" :value="finalAmount">
                        <input type="hidden" name="phone" :value="phone">

                        <button type="submit"
                                :disabled="loading"
                                class="w-full py-4 bg-gradient-to-r from-brand-800 to-brand-700 hover:from-brand-700 hover:to-brand-600 text-white rounded-2xl font-bold text-base shadow-lg hover:shadow-xl transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-3">
                            <span x-show="!loading">
                                <span class="mr-1">💳</span> Pay with Chapa
                            </span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Redirecting...
                            </span>
                        </button>
                    </form>

                    <p class="text-xs text-center text-gray-400 mt-4">
                        Secured by <span class="font-semibold text-gray-500">Chapa</span> · 🇪🇹 Ethiopia
                    </p>
                </div>
            </div>

            <!-- Footer note -->
            <p class="text-center text-xs text-gray-400 mt-6">
                Powered by <span class="font-semibold text-brand-700">{{ config('app.name') }}</span> · Help those in need
            </p>
        </div>
    </div>

    <!-- Ethiopian flag stripe at bottom -->
    <div class="eth-stripe h-1.5 w-full flex-shrink-0"></div>
</div>
@endsection
