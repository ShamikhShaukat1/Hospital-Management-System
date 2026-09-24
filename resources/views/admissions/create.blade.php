@extends('layouts.app')

@section('title', 'Patient Admission')
@section('page_title', 'Admit Patient to Ward')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
        <h3 class="text-lg font-bold text-slate-800 pb-3 mb-4 border-b">Inpatient Admission Registration</h3>

        <form method="POST" action="{{ route('admissions.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Select Patient *</label>
                <select name="patient_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    <option value="">-- Choose Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }} ({{ $patient->patient_id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Attending Doctor *</label>
                    <select name="doctor_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">-- Choose Doctor --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                Dr. {{ $doctor->name }} ({{ $doctor->specialization }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Room Allocation *</label>
                    <select id="room_id" name="room_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">-- Select Room --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                Room {{ $room->room_number }} ({{ $room->room_type }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Available Bed *</label>
                    <select id="bed_id" name="bed_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">-- Select Available Bed --</option>
                        @foreach($availableBeds as $bed)
                            <option value="{{ $bed->id }}" data-room="{{ $bed->room_id }}" {{ old('bed_id') == $bed->id ? 'selected' : '' }}>
                                Bed {{ $bed->bed_number }} (Room {{ $bed->room->room_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Admission Date *</label>
                    <input type="date" name="admission_date" value="{{ old('admission_date', date('Y-m-d')) }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Reason for Inpatient Admission *</label>
                <input type="text" name="reason" value="{{ old('reason') }}" placeholder="e.g. Post-operative observation, severe pneumonia" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Primary Diagnosis *</label>
                <input type="text" name="diagnosis" value="{{ old('diagnosis') }}" placeholder="e.g. Community-Acquired Pneumonia Stage II" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Admission Clinical Notes</label>
                <textarea name="notes" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">{{ old('notes') }}</textarea>
            </div>

            <div class="pt-4 border-t flex justify-end gap-2">
                <a href="{{ route('admissions.index') }}" class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold">Confirm Admission</button>
            </div>
        </form>
    </div>
</div>
@endsection
