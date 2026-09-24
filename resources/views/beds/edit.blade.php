@extends('layouts.app')

@section('title', 'Edit Bed')
@section('page_title', 'Update Bed Details')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 pb-3 mb-4 border-b">Edit Bed #{{ $bed->bed_number }}</h3>

            <form method="POST" action="{{ route('beds.update', $bed) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Bed Identifier / Number
                        *</label>
                    <input type="text" name="bed_number" value="{{ old('bed_number', $bed->bed_number) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    @error('bed_number')
                        <span class="text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Assigned Room *</label>
                    <select name="room_id" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}"
                                {{ old('room_id', $bed->room_id) == $room->id ? 'selected' : '' }}>
                                Room {{ $room->room_number }} ({{ $room->room_type }} - Floor {{ $room->floor }})
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <span class="text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Status *</label>
                    <select name="status" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        @foreach (['Available', 'Occupied', 'Reserved', 'Maintenance'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $bed->status) === $status ? 'selected' : '' }}>{{ $status }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('beds.index') }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm">Update
                        Bed</button>
                </div>
            </form>
        </div>
    </div>
@endsection
