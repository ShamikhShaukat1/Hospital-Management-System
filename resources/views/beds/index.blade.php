@extends('layouts.app')

@section('title', 'Bed Occupancy')
@section('page_title', 'Hospital Beds & Ward Occupancy')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <p class="text-sm text-slate-500">Live bed status monitoring across all wings and intensive care units.</p>
            <div class="flex items-center gap-2">
                <a href="{{ route('beds.create') }}"
                    class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold flex items-center gap-2 shadow-sm transition">
                    + Add New Bed
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <form method="GET" action="{{ route('beds.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Filter by Room</label>
                    <select name="room_id" onchange="this.form.submit()"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">All Rooms</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                Room {{ $room->room_number }} ({{ $room->room_type }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Filter by Status</label>
                    <select name="status" onchange="this.form.submit()"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">All Statuses</option>
                        @foreach (['Available', 'Occupied', 'Maintenance', 'Reserved'] as $st)
                            <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                                {{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <a href="{{ route('beds.index') }}"
                        class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                        Clear
                        Filters</a>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($beds as $bed)
                <div
                    class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 text-center transition hover:shadow-md flex flex-col justify-between">
                    <div>
                        <div
                            class="w-10 h-10 rounded-full mx-auto mb-2 flex items-center justify-center text-lg {{ $bed->status === 'Available' ? 'bg-emerald-50 text-emerald-600' : ($bed->status === 'Occupied' ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-500') }}">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="font-bold text-slate-800 text-sm">Bed {{ $bed->bed_number }}</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">Room {{ $bed->room->room_number ?? '-' }}</div>
                        <div class="text-[10px] text-slate-500 font-medium">{{ $bed->room->room_type ?? 'General' }}</div>

                        <div class="mt-2">
                            <span
                                class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-full {{ $bed->status === 'Available' ? 'bg-emerald-100 text-emerald-800' : ($bed->status === 'Occupied' ? 'bg-rose-100 text-rose-800' : 'bg-slate-200 text-slate-700') }}">
                                {{ $bed->status }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 pt-2 border-t border-slate-100 flex items-center justify-center gap-3 text-[11px]">
                        <a href="{{ route('beds.edit', $bed) }}"
                            class="text-slate-600 font-semibold hover:text-teal-700">Edit</a>
                        <span class="text-slate-300">&bull;</span>
                        <a href="{{ route('beds.delete', $bed) }}"
                            class="text-rose-600 font-semibold hover:text-rose-800">Delete</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-8 rounded-xl border border-slate-200 text-center text-slate-400">
                    No beds configured.
                </div>
            @endforelse
        </div>

        @if ($beds->hasPages())
            <div class="p-4 bg-white rounded-xl border border-slate-200">
                {{ $beds->links() }}
            </div>
        @endif
    </div>
@endsection
