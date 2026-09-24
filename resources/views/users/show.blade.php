@extends('layouts.app')

@section('title', 'User Profile - ' . $user->name)
@section('page_title', 'User Profile & Permissions')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <a href="{{ route('users.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                &larr; Back to Users
            </a>
            <div class="flex gap-2">
                <a href="{{ route('users.edit', $user) }}"
                    class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-semibold transition">
                    <i class="far fa-edit mr-1"></i> Edit User
                </a>
                @if ($user->id !== auth()->id())
                    <form method="POST" action="{{ route('users.destroy', $user) }}"
                        onsubmit="return confirm('Are you sure you want to delete this user account?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold transition">
                            <i class="far fa-trash-alt mr-1"></i> Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 rounded-full bg-teal-700 text-white font-bold flex items-center justify-center text-lg">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $user->name }}</h2>
                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                    </div>
                </div>
                <div>
                    <span
                        class="px-3 py-1 rounded-full text-xs font-semibold uppercase {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                        {{ $user->status }}
                    </span>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-xs text-slate-700">
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">System Role</span>
                    <span class="font-bold text-sm text-slate-800 mt-1 block">
                        {{ str_replace('_', ' ', strtoupper($user->role)) }}
                    </span>
                </div>

                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Phone Number</span>
                    <span class="font-semibold text-sm text-slate-800 mt-1 block">
                        {{ $user->phone ?? 'Not specified' }}
                    </span>
                </div>

                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Account Created</span>
                    <span class="font-medium text-slate-800 mt-1 block">
                        {{ $user->created_at ? $user->created_at->format('M d, Y h:i A') : 'N/A' }}
                    </span>
                </div>

                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase">Last Updated</span>
                    <span class="font-medium text-slate-800 mt-1 block">
                        {{ $user->updated_at ? $user->updated_at->format('M d, Y h:i A') : 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
