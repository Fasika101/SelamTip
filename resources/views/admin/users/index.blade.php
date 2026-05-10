@extends('layouts.admin')

@section('title', 'Users')
@section('page-title', 'User Management')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-gray-500 text-sm">{{ $users->count() }} user(s)</p>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('admin.users.create') }}"
       class="bg-brand-800 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-colors flex items-center gap-2 shadow-md">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New User
    </a>
    @endif
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if($users->isEmpty())
        <div class="text-center py-16 text-gray-400">No users found.</div>
    @else
        <table class="w-full">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                <tr>
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-left">Role</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Joined</th>
                    @if(auth()->user()->isAdmin())
                    <th class="px-6 py-3 text-right">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white flex-shrink-0
                                {{ $user->isAdmin() ? 'bg-brand-800' : 'bg-amber-500' }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 flex items-center gap-2">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="text-xs bg-blue-50 text-blue-600 border border-blue-100 px-1.5 py-0.5 rounded-full font-medium">You</span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->isAdmin())
                            <span class="bg-brand-50 text-brand-800 text-xs font-bold px-3 py-1 rounded-full border border-brand-100">
                                👑 Admin
                            </span>
                        @else
                            <span class="bg-amber-50 text-amber-700 text-xs font-bold px-3 py-1 rounded-full border border-amber-100">
                                🛠 Manager
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($user->is_active)
                            <span class="flex items-center gap-1.5 text-green-700 text-sm font-medium">
                                <span class="w-2 h-2 bg-green-400 rounded-full"></span> Active
                            </span>
                        @else
                            <span class="flex items-center gap-1.5 text-gray-400 text-sm font-medium">
                                <span class="w-2 h-2 bg-gray-300 rounded-full"></span> Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                    @if(auth()->user()->isAdmin())
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="text-sm bg-gray-50 hover:bg-gray-100 text-gray-700 px-3 py-1.5 rounded-xl border border-gray-100 font-medium transition-colors">
                                Edit
                            </a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Delete {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-sm bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-xl border border-red-100 font-medium transition-colors">
                                    Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
