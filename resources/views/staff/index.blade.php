@extends('layouts.app')

@section('title', 'Hospital Staff')
@section('page_title', 'Administrative & Operational Staff')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('staff.index') }}" class="flex items-center gap-3 w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search staff, role, ID..."
                    class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-teal-500">
                <button type="submit"
                    class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                    Search
                </button>
            </form>

            <a href="{{ route('staff.create') }}"
                class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                + Add Staff Member
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                        <tr>
                            <th class="p-3.5 px-6">Staff ID</th>
                            <th class="p-3.5 px-6">Name</th>
                            <th class="p-3.5 px-6">Designation</th>
                            <th class="p-3.5 px-6">Department</th>
                            <th class="p-3.5 px-6">Contact</th>
                            <th class="p-3.5 px-6">Status</th>
                            <th class="p-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($staff as $member)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3.5 px-6 font-mono font-bold text-teal-700">{{ $member->staff_id }}</td>
                                <td class="p-3.5 px-6 font-bold text-slate-900">{{ $member->name }}</td>
                                <td class="p-3.5 px-6 font-semibold text-slate-800">{{ $member->designation }}</td>
                                <td class="p-3.5 px-6">{{ $member->department->name ?? 'General Admin' }}</td>
                                <td class="p-3.5 px-6">
                                    <div>{{ $member->phone }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $member->email }}</div>
                                </td>
                                <td class="p-3.5 px-6">
                                    <span
                                        class="px-2 py-0.5 rounded font-semibold {{ $member->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </td>
                                <td class="p-3.5 px-6 text-right space-x-2">
                                    <a href="{{ route('staff.show', $member) }}"
                                        class="text-teal-700 hover:text-teal-900 font-semibold">View</a>
                                    <a href="{{ route('staff.edit', $member) }}"
                                        class="text-amber-600 hover:text-amber-800 font-semibold">Edit</a>
                                    <a href="{{ route('staff.delete', $member) }}"
                                        class="text-rose-600 hover:text-rose-800 font-semibold">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-400">No staff records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($staff->hasPages())
                <div class="p-4 border-t border-slate-100">{{ $staff->links() }}</div>
            @endif
        </div>
    </div>
@endsection
