@extends('layouts.app')

@section('title', 'Edit Medical Record')
@section('page_title', 'Edit Patient Medical Record')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 pb-3 mb-4 border-b">Edit Medical Record</h3>

            <form method="POST" action="{{ route('medical-records.update', $medicalRecord) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Patient *</label>
                        <select name="patient_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">-- Choose Patient --</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ old('patient_id', $medicalRecord->patient_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }} ({{ $patient->patient_id }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Doctor *</label>
                        <select name="doctor_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">-- Attending Physician --</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}"
                                    {{ old('doctor_id', $medicalRecord->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->name }} ({{ $doctor->specialization }})
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Primary Diagnosis *</label>
                        <input type="text" name="diagnosis" value="{{ old('diagnosis', $medicalRecord->diagnosis) }}"
                            placeholder="e.g. Acute Bacterial Pharyngitis" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        @error('diagnosis')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Record Date *</label>
                        <input type="date" name="record_date"
                            value="{{ old('record_date', \Carbon\Carbon::parse($medicalRecord->record_date)->format('Y-m-d')) }}"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        @error('record_date')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Observed Symptoms</label>
                        <textarea name="symptoms" rows="2" placeholder="Fever (101.4F), sore throat, swollen cervical lymph nodes..."
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">{{ old('symptoms', $medicalRecord->symptoms) }}</textarea>
                        @error('symptoms')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Treatment Plan &
                            Interventions</label>
                        <textarea name="treatment" rows="2" placeholder="Antibiotic therapy, warm saline gargle, hydration rest..."
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">{{ old('treatment', $medicalRecord->treatment) }}</textarea>
                        @error('treatment')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Physician Notes</label>
                        <textarea name="notes" rows="2"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">{{ old('notes', $medicalRecord->notes) }}</textarea>
                        @error('notes')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('medical-records.show', $medicalRecord) }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold">Update
                        Medical Record</button>
                </div>
            </form>
        </div>
    </div>
@endsection
