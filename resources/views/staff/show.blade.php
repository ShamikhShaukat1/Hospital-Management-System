@extends('layouts.app')

@section('title', 'Staff Profile')
@section('page_title', 'Staff Member Details')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <span
                        class="text-xs font-mono font-bold text-teal-700 uppercase tracking-wider">{{ $staff->staff_id }}</span>
                    <h2 class="text-xl font-bold text-slate-900 mt-1">{{ $staff->name }}</h2>
                    <p class="text-xs text-slate-500 font-semibold">{{ $staff->designation }}</p>
                </div>
                <span
                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $staff->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                    {{ ucfirst($staff->status) }}
                </span>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <span class="block text-xs uppercase font-semibold text-slate-400 mb-1">Department</span>
                    <p class="font-bold text-slate-800">{{ $staff->department->name ?? 'General Admin' }}</p>
                </div>

                <div>
                    <span class="block text-xs uppercase font-semibold text-slate-400 mb-1">Salary</span>
                    <p class="font-bold text-slate-800">
                        {{ $staff->salary ? '$' . number_format($staff->salary, 2) : 'Not specified' }}
                    </p>
                </div>

                <div>
                    <span class="block text-xs uppercase font-semibold text-slate-400 mb-1">Phone Number</span>
                    <p class="font-bold text-slate-800">{{ $staff->phone }}</p>
                </div>

                <div>
                    <span class="block text-xs uppercase font-semibold text-slate-400 mb-1">Email Address</span>
                    <p class="font-bold text-slate-800">{{ $staff->email }}</p>
                </div>

                <div>
                    <span class="block text-xs uppercase font-semibold text-slate-400 mb-1">Date Joined</span>
                    <p class="font-bold text-slate-800">{{ $staff->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('staff.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">←
                    Back to Staff Directory</a>
                <div class="flex gap-2">
                    <a href="{{ route('staff.edit', $staff) }}"
                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-semibold transition">
                        Edit Profile
                    </a>
                    <a href="{{ route('staff.delete', $staff) }}"
                        class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition">
                        Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
