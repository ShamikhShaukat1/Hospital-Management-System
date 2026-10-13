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
                    <i class="fas fa-plus text-xs"></i> Add New Bed
                </a>
            </div>
        </div>

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
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <a href="{{ route('beds.index') }}"
                        class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <th scope="col" class="px-6 py-3.5">Bed Number</th>
                            <th scope="col" class="px-6 py-3.5">Room Number</th>
                            <th scope="col" class="px-6 py-3.5">Room Type</th>
                            <th scope="col" class="px-6 py-3.5">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($beds as $bed)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold {{ $bed->status === 'Available' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : ($bed->status === 'Occupied' ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-slate-100 text-slate-500 border border-slate-200') }}">
                                            <i class="fas fa-bed"></i>
                                        </div>
                                        <span class="font-bold text-slate-900">Bed {{ $bed->bed_number }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-slate-700 font-medium">
                                    Room {{ $bed->room->room_number ?? '-' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                    {{ $bed->room->room_type ?? 'General' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-block px-2.5 py-1 text-xs font-bold rounded-full {{ $bed->status === 'Available' ? 'bg-emerald-100 text-emerald-800' : ($bed->status === 'Occupied' ? 'bg-rose-100 text-rose-800' : 'bg-slate-200 text-slate-700') }}">
                                        {{ $bed->status }}
                                    </span>
                                </td>

                                <td class="p-3.5 px-6 text-right space-x-2">
                                    <a href="{{ route('beds.edit', $bed) }}"
                                        class="text-amber-600 hover:text-amber-800 font-semibold">Edit</a>

                                    </a>
                                    <a href="{{ route('beds.delete', $bed) }}"
                                        class="text-rose-600 hover:text-rose-800 font-semibold">Delete</a>

                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-slate-400">
                                    <i class="fas fa-bed text-4xl mb-3 text-slate-300 block"></i>
                                    No beds configured.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($beds->hasPages())
            <div class="p-4 bg-white rounded-xl border border-slate-200">
                {{ $beds->links() }}
            </div>
        @endif
    </div>
@endsection
