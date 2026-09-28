@extends('layouts.app')

@section('title', 'Edit Admission')
@section('page_title', 'Update Admission Details')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Edit Admission Record</h3>
                    <p class="text-xs text-slate-500 font-mono mt-0.5">{{ $admission->admission_id }} &bull;
                        {{ $admission->patient->name ?? 'N/A' }}</p>
                </div>
                <a href="{{ route('admissions.show', $admission) }}"
                    class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-lg text-xs text-rose-700">
                    <p class="font-bold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admissions.update', $admission) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Patient</label>
                        <input type="text" disabled
                            value="{{ $admission->patient->name ?? '-' }} ({{ $admission->patient->patient_id ?? '-' }})"
                            class="w-full px-3 py-2 bg-slate-100 border border-slate-200 text-slate-500 rounded-lg text-sm cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Assigned Room & Bed</label>
                        <input type="text" disabled
                            value="Room {{ $admission->room->room_number ?? '-' }} - Bed {{ $admission->bed->bed_number ?? '-' }}"
                            class="w-full px-3 py-2 bg-slate-100 border border-slate-200 text-slate-500 rounded-lg text-sm cursor-not-allowed">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Attending Doctor *</label>
                        <select name="doctor_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}"
                                    {{ old('doctor_id', $admission->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->name }} ({{ $doctor->specialization }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Admission Status *</label>
                        <select name="status" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="Admitted"
                                {{ old('status', $admission->status) == 'Admitted' ? 'selected' : '' }}>Admitted</option>
                            <option value="Discharged"
                                {{ old('status', $admission->status) == 'Discharged' ? 'selected' : '' }}>Discharged
                            </option>
                            <option value="Transferred"
                                {{ old('status', $admission->status) == 'Transferred' ? 'selected' : '' }}>Transferred
                            </option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Reason for Admission *</label>
                    <input type="text" name="reason" value="{{ old('reason', $admission->reason) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Primary Diagnosis *</label>
                    <input type="text" name="diagnosis" value="{{ old('diagnosis', $admission->diagnosis) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Clinical Notes</label>
                    <textarea name="notes" rows="3"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">{{ old('notes', $admission->notes) }}</textarea>
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('admissions.show', $admission) }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                        Update Admission
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
