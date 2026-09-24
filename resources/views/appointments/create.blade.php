@extends('layouts.app')

@section('title', 'Book Appointment')
@section('page_title', 'Schedule Patient Appointment')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
        <h3 class="text-lg font-bold text-slate-800 pb-3 mb-4 border-b">Appointment Details</h3>

        <form method="POST" action="{{ route('appointments.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Select Patient *</label>
                <select name="patient_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    <option value="">-- Choose Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ (old('patient_id', request('patient_id')) == $patient->id) ? 'selected' : '' }}>
                            {{ $patient->name }} ({{ $patient->patient_id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Doctor *</label>
                    <select name="doctor_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">-- Choose Doctor --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ (old('doctor_id', request('doctor_id')) == $doctor->id) ? 'selected' : '' }}>
                                Dr. {{ $doctor->name }} ({{ $doctor->specialization }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Department</label>
                    <select name="department_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">-- General / Auto-detect --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Appointment Date *</label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date', date('Y-m-d')) }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Time Slot *</label>
                    <input type="time" name="appointment_time" value="{{ old('appointment_time', '09:00') }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Reason for Visit *</label>
                <input type="text" name="reason" value="{{ old('reason') }}" placeholder="e.g. Chronic chest discomfort, routine checkup" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Initial Status *</label>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    <option value="Confirmed">Confirmed</option>
                    <option value="Pending">Pending Confirmation</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Clinical Notes</label>
                <textarea name="notes" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">{{ old('notes') }}</textarea>
            </div>

            <div class="pt-4 border-t flex justify-end gap-2">
                <a href="{{ route('appointments.index') }}" class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm">Schedule Appointment</button>
            </div>
        </form>
    </div>
</div>
@endsection
