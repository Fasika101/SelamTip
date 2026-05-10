@extends('layouts.admin')

@section('title', 'Edit ' . $beggar->name)
@section('page-title', 'Edit Profile')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-brand-800 to-brand-600 px-6 py-5">
            <h2 class="text-white font-bold text-lg">Edit — {{ $beggar->name }}</h2>
            <p class="text-brand-200 text-sm mt-0.5">Update profile information below.</p>
        </div>

        <form method="POST" action="{{ route('admin.beggars.update', $beggar) }}" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf @method('PUT')

            <!-- Photo upload -->
            <div x-data="{ preview: '{{ $beggar->photo_url }}' }" class="text-center">
                <div class="relative inline-block">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-dashed border-amber-300 bg-amber-50 flex items-center justify-center mx-auto cursor-pointer hover:border-brand-600 transition-colors"
                         @click="$refs.photoInput.click()">
                        <img :src="preview" class="w-full h-full object-cover absolute inset-0 rounded-2xl"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($beggar->name) }}&background=b45309&color=fff&size=96'">
                    </div>
                </div>
                <input type="file" name="photo" accept="image/*" class="hidden" x-ref="photoInput"
                       @change="preview = URL.createObjectURL($event.target.files[0])">
                <p class="text-xs text-gray-400 mt-2">Click to change photo</p>
                @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{ old('name', $beggar->name) }}" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all @error('name') border-red-300 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- City -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">City <span class="text-red-400">*</span></label>
                <input type="text" name="city" value="{{ old('city', $beggar->city) }}" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all">
            </div>

            <!-- Bio -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Short Story</label>
                <textarea name="bio" rows="3"
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all resize-none">{{ old('bio', $beggar->bio) }}</textarea>
            </div>

            <!-- Active toggle -->
            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-xl border border-gray-100">
                <div>
                    <p class="font-semibold text-gray-700 text-sm">Profile Active</p>
                    <p class="text-xs text-gray-400 mt-0.5">Inactive profiles cannot receive tips</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                           {{ $beggar->is_active ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-700"></div>
                </label>
            </div>

            <!-- Submit -->
            <div class="pt-2 flex gap-3">
                <a href="{{ route('admin.beggars.show', $beggar) }}"
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
