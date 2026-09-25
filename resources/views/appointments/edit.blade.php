@extends('layouts.app')

@section('title', 'Edit Appointment')
@section('page_title', 'Modify Scheduled Appointment')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between pb-3 mb-6 border-b">
                <h3 class="text-lg font-bold text-slate-800">Edit Appointment Details</h3>
                <span
                    class="px-2.5 py-1 text-xs font-semibold rounded-md uppercase tracking-wider bg-slate-100 text-slate-700">
                    ID: #{{ $appointment->id }}
                </span>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-xs mb-6">
                    <div class="font-bold mb-1">Please address the following errors:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Select Patient *</label>
                    <select name="patient_id" required
                        class="w-full px-3 py-2 bg-slate-50 border @error('patient_id') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">-- Choose Patient --</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}"
                                {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }} ({{ $patient->patient_id ?? $patient->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Doctor *</label>
                        <select name="doctor_id" required
                            class="w-full px-3 py-2 bg-slate-50 border @error('doctor_id') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">-- Choose Doctor --</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}"
                                    {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->name }} ({{ $doctor->specialization ?? 'General' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Department</label>
                        <select name="department_id"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">-- General / Auto-detect --</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ old('department_id', $appointment->department_id) == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Appointment Date *</label>
                        <input type="date" name="appointment_date"
                            value="{{ old('appointment_date', $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') : '') }}"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border @error('appointment_date') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Time Slot *</label>
                        <input type="time" name="appointment_time"
                            value="{{ old('appointment_time', $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') : '') }}"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border @error('appointment_time') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Reason for Visit *</label>
                    <input type="text" name="reason" value="{{ old('reason', $appointment->reason) }}"
                        placeholder="e.g. Chronic chest discomfort, routine checkup" required
                        class="w-full px-3 py-2 bg-slate-50 border @error('reason') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Appointment Status *</label>
                    <select name="status"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="Confirmed"
                            {{ old('status', $appointment->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Pending" {{ old('status', $appointment->status) == 'Pending' ? 'selected' : '' }}>
                            Pending Confirmation</option>
                        <option value="Completed"
                            {{ old('status', $appointment->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled"
                            {{ old('status', $appointment->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Clinical Notes</label>
                    <textarea name="notes" rows="3"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">{{ old('notes', $appointment->notes) }}</textarea>
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('appointments.index') }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm transition">Update
                        Appointment</button>
                </div>
            </form>
        </div>
    </div>
@endsection
