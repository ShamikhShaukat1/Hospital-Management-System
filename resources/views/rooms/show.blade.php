@extends('layouts.app')

@section('title', 'Room ' . $room->room_number)
@section('page_title', 'Room Overview')

@section('content')
    <div class="space-y-6 max-w-4xl mx-auto">
        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-xl font-bold text-slate-800">Room {{ $room->room_number }}</h2>
                        <span
                            class="px-2 py-0.5 text-xs font-semibold rounded {{ $room->status === 'available' ? 'bg-emerald-100 text-emerald-800' : ($room->status === 'occupied' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                            {{ ucfirst($room->status) }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1">{{ $room->room_type }} &bull; Floor {{ $room->floor }}</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('rooms.edit', $room) }}"
                        class="px-3 py-1.5 border border-slate-300 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50">Edit
                        Room</a>
                    <a href="{{ route('rooms.delete', $room) }}"
                        class="px-3 py-1.5 border border-rose-200 text-rose-600 rounded-lg text-xs font-semibold hover:bg-rose-50">Delete</a>
                    <a href="{{ route('rooms.index') }}"
                        class="px-3 py-1.5 bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold hover:bg-slate-200">Back
                        to List</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6 text-sm">
                <div class="bg-slate-50 p-3 rounded-lg border border-slate-200">
                    <span class="block text-xs uppercase text-slate-400 font-semibold mb-1">Department</span>
                    <span class="font-semibold text-slate-700">{{ $room->department->name ?? 'General' }}</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-lg border border-slate-200">
                    <span class="block text-xs uppercase text-slate-400 font-semibold mb-1">Total Capacity</span>
                    <span class="font-semibold text-slate-700">{{ $room->beds->count() }} Beds</span>
                </div>
                <div class="bg-slate-50 p-3 rounded-lg border border-slate-200">
                    <span class="block text-xs uppercase text-slate-400 font-semibold mb-1">Available Beds</span>
                    <span class="font-semibold text-emerald-700">{{ $room->beds->where('status', 'Available')->count() }}
                        Free</span>
                </div>
            </div>

            @if ($room->description)
                <div class="mb-6">
                    <h4 class="text-xs font-semibold uppercase text-slate-500 mb-1">Notes & Details</h4>
                    <p class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-100">
                        {{ $room->description }}</p>
                </div>
            @endif

            <div>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-bold text-slate-800">Associated Beds</h3>
                    <a href="{{ route('beds.index', ['room_id' => $room->id]) }}"
                        class="text-xs font-semibold text-teal-700 hover:underline">Manage Beds &rarr;</a>
                </div>

                <div class="divide-y divide-slate-100 border rounded-lg overflow-hidden">
                    @forelse($room->beds as $bed)
                        <div class="p-3 bg-white flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-700">Bed #{{ $bed->bed_number }}</span>
                                @if ($bed->admissions && $bed->admissions->first() && $bed->admissions->first()->patient)
                                    <span class="text-slate-500 ml-2">&bull; Patient:
                                        {{ $bed->admissions->first()->patient->name }}</span>
                                @endif
                            </div>
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase {{ $bed->status === 'Available' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $bed->status }}
                            </span>
                        </div>
                    @empty
                        <div class="p-4 text-center text-xs text-slate-400">No beds currently added to this room.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
