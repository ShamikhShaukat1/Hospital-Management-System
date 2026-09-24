@extends('layouts.app')

@section('title', 'Add New Room')
@section('page_title', 'Configure New Hospital Room')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 pb-3 mb-4 border-b">Room Details</h3>

            <form method="POST" action="{{ route('rooms.store') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Room Number *</label>
                        <input type="text" name="room_number" value="{{ old('room_number') }}" required
                            placeholder="e.g. R-101"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        @error('room_number')
                            <span class="text-xs text-rose-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Room Type *</label>
                        <select name="room_type" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">-- Choose Type --</option>
                            @foreach (['General Ward', 'Semi-Private', 'Private', 'ICU', 'Emergency', 'Operation Theatre'] as $type)
                                <option value="{{ $type }}" {{ old('room_type') == $type ? 'selected' : '' }}>
                                    {{ $type }}</option>
                            @endforeach
                        </select>
                        @error('room_type')
                            <span class="text-xs text-rose-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Department</label>
                        <select name="department_id"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">-- General / Unassigned --</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <span class="text-xs text-rose-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Floor *</label>
                        <input type="number" name="floor" min="0" value="{{ old('floor', 0) }}" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        @error('floor')
                            <span class="text-xs text-rose-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Status *</label>
                    <select name="status"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="occupied" {{ old('status') === 'occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance
                        </option>
                    </select>
                    @error('status')
                        <span class="text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Description / Equipment
                        Details</label>
                    <textarea name="description" rows="3" placeholder="Optional room notes or equipment listing..."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-xs text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('rooms.index') }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm">Save
                        Room</button>
                </div>
            </form>
        </div>
    </div>
@endsection
