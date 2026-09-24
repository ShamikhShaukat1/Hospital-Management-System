@extends('layouts.app')

@section('title', 'Rooms & Wards')
@section('page_title', 'Hospital Rooms & Wards')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <p class="text-sm text-slate-500">Monitor room allocations, maintenance status, and bed configurations.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('beds.index') }}"
                    class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                    View Bed Occupancy
                </a>
                <a href="{{ route('rooms.create') }}"
                    class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                    + Add New Room
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <form method="GET" action="{{ route('rooms.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <select name="type" onchange="this.form.submit()"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs font-medium focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">All Room Types</option>
                        @foreach (['General Ward', 'Semi-Private', 'Private', 'ICU', 'Emergency', 'Operation Theatre'] as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="floor" onchange="this.form.submit()"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs font-medium focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">All Floors</option>
                        @for ($i = 0; $i <= 10; $i++)
                            <option value="{{ $i }}"
                                {{ request('floor') !== null && request('floor') == $i ? 'selected' : '' }}>Floor
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    @if (request()->hasAny(['type', 'floor']))
                        <a href="{{ route('rooms.index') }}"
                            class="px-3 py-2 text-xs text-rose-600 font-semibold hover:underline">Clear Filters</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="py-3 px-4">Room No.</th>
                            <th class="py-3 px-4">Type</th>
                            <th class="py-3 px-4">Department</th>
                            <th class="py-3 px-4">Floor</th>
                            <th class="py-3 px-4">Bed Status</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($rooms as $room)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 font-mono font-bold text-teal-800">
                                    <a href="{{ route('rooms.show', $room) }}" class="hover:underline">
                                        Room {{ $room->room_number }}
                                    </a>
                                </td>

                                <td class="py-3.5 px-4 font-medium text-slate-700">
                                    {{ $room->room_type }}
                                </td>

                                <td class="py-3.5 px-4 text-slate-600 text-xs">
                                    {{ $room->department->name ?? 'General / Unassigned' }}
                                </td>

                                <td class="py-3.5 px-4 text-slate-600 text-xs">
                                    Floor {{ $room->floor }}
                                </td>

                                <td class="py-3.5 px-4 text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-slate-700">
                                            {{ $room->beds->count() }} total
                                        </span>
                                        <span
                                            class="text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-100">
                                            {{ $room->beds->where('status', 'Available')->count() }} free
                                        </span>
                                    </div>
                                </td>

                                <td class="py-3.5 px-4">
                                    <span
                                        class="inline-flex px-2 py-0.5 text-xs font-semibold rounded {{ $room->status === 'available' ? 'bg-emerald-100 text-emerald-800' : ($room->status === 'occupied' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </td>

                                <td class="py-3.5 px-4 text-right whitespace-nowrap text-xs font-semibold">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('beds.index', ['room_id' => $room->id]) }}"
                                            class="text-teal-700 hover:underline mr-1">
                                            Manage Beds
                                        </a>
                                        <a href="{{ route('rooms.show', $room) }}"
                                            class="text-slate-600 hover:text-teal-700">
                                            View
                                        </a>
                                        <a href="{{ route('rooms.edit', $room) }}"
                                            class="text-slate-600 hover:text-teal-700">
                                            Edit
                                        </a>
                                        <a href="{{ route('rooms.delete', $room) }}"
                                            class="text-rose-600 hover:text-rose-800">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    No rooms configured.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($rooms->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50">
                    {{ $rooms->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
