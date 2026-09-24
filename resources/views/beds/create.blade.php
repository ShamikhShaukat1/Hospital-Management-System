@extends('layouts.app')

@section('title', 'Add New Bed')
@section('page_title', 'Register New Bed Unit')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 pb-3 mb-4 border-b">Bed Information</h3>

            <form method="POST" action="{{ route('beds.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Bed Identifier / Number
                        *</label>
                    <input type="text" name="bed_number" value="{{ old('bed_number') }}" required
                        placeholder="e.g. B-101-A, ICU-01"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    @error('bed_number')
                        <span class="text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Assign to Room *</label>
                    <select name="room_id" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">-- Choose Assigned Room --</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}"
                                {{ old('room_id', request('room_id')) == $room->id ? 'selected' : '' }}>
                                Room {{ $room->room_number }} ({{ $room->room_type }} - Floor {{ $room->floor }})
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <span class="text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Initial Status *</label>
                    <select name="status" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="Available" {{ old('status') === 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Occupied" {{ old('status') === 'Occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="Reserved" {{ old('status') === 'Reserved' ? 'selected' : '' }}>Reserved</option>
                        <option value="Maintenance" {{ old('status') === 'Maintenance' ? 'selected' : '' }}>Maintenance
                        </option>
                    </select>
                    @error('status')
                        <span class="text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('beds.index') }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm">Save
                        Bed</button>
                </div>
            </form>
        </div>
    </div>
@endsection
