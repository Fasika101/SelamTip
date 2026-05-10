@extends('layouts.admin')

@section('title', 'New Profile')
@section('page-title', 'Create New Profile')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-brand-800 to-brand-600 px-6 py-5">
            <h2 class="text-white font-bold text-lg">New Beneficiary Profile</h2>
            <p class="text-brand-200 text-sm mt-0.5">Fill in the details below to create a profile and generate a QR code.</p>
        </div>

        <form method="POST" action="{{ route('admin.beggars.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            <!-- Photo upload -->
            <div x-data="{ preview: null }" class="text-center">
                <div class="relative inline-block">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-dashed border-amber-300 bg-amber-50 flex items-center justify-center mx-auto cursor-pointer hover:border-brand-600 transition-colors"
                         @click="$refs.photoInput.click()">
                        <img x-show="preview" :src="preview" class="w-full h-full object-cover absolute inset-0 rounded-2xl">
                        <div x-show="!preview" class="text-center">
                            <svg class="w-8 h-8 text-amber-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <p class="text-xs text-amber-400 mt-1">Photo</p>
                        </div>
                    </div>
                </div>
                <input type="file" name="photo" accept="image/*" class="hidden" x-ref="photoInput"
                       @change="preview = URL.createObjectURL($event.target.files[0])">
                <p class="text-xs text-gray-400 mt-2">Click to upload photo (optional)</p>
                @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="e.g. Abebe Girma"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all @error('name') border-red-300 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- City -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">City <span class="text-red-400">*</span></label>
                <input type="text" name="city" value="{{ old('city', 'Addis Ababa') }}" required
                       placeholder="e.g. Addis Ababa"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all @error('city') border-red-300 @enderror">
                @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Bio -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Short Story <span class="text-gray-400 font-normal">(optional)</span></label>
                <textarea name="bio" rows="3" placeholder="A brief personal story shown on the tip page..."
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all resize-none @error('bio') border-red-300 @enderror">{{ old('bio') }}</textarea>
                @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="pt-2 flex gap-3">
                <a href="{{ route('admin.beggars.index') }}"
                   class="flex-1 text-center py-3 border border-gray-200 text-gray-600 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="flex-1 py-3 bg-brand-800 hover:bg-brand-700 text-white rounded-xl font-bold text-sm transition-colors shadow-md flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Create Profile & Generate QR
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
