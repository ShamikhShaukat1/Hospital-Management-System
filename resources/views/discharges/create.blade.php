@extends('layouts.app')

@section('title', 'Discharge Patient')
@section('page_title', 'Finalize Inpatient Discharge')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 pb-3 mb-4 border-b">
                Discharge Patient: {{ $admission->patient->name ?? 'Patient' }}
            </h3>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-xs mb-6">
                    <div class="font-bold mb-1">Please fix the following errors:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-teal-50 border border-teal-200 p-4 rounded-xl text-xs text-teal-900 mb-6">
                <span class="font-bold">Admission Reference:</span> {{ $admission->admission_id }} &bull;
                Room {{ $admission->room->room_number ?? '-' }}, Bed {{ $admission->bed->bed_number ?? '-' }} &bull;
                Admitted on {{ optional($admission->admission_date)->format('M d, Y') ?? '-' }}.
                <div class="mt-1 text-teal-700">
                    Upon submitting, Bed {{ $admission->bed->bed_number ?? 'N/A' }} will automatically be released and set
                    to <strong>Available</strong>.
                </div>
            </div>

            <form method="POST" action="{{ route('discharges.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="admission_id" value="{{ $admission->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Discharge Date *</label>
                        <input type="date" name="discharge_date" value="{{ old('discharge_date', date('Y-m-d')) }}"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border @error('discharge_date') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        @error('discharge_date')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Discharge Time *</label>
                        <input type="time" name="discharge_time" value="{{ old('discharge_time', date('H:i')) }}"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border @error('discharge_time') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        @error('discharge_time')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Final Medical Diagnosis
                        *</label>
                    <input type="text" name="diagnosis" value="{{ old('diagnosis', $admission->diagnosis) }}" required
                        class="w-full px-3 py-2 bg-slate-50 border @error('diagnosis') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    @error('diagnosis')
                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Treatment & Clinical Summary
                        *</label>
                    <textarea name="treatment_summary" rows="3" required
                        placeholder="Hospital treatment course, resolved symptoms, procedures performed..."
                        class="w-full px-3 py-2 bg-slate-50 border @error('treatment_summary') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">{{ old('treatment_summary') }}</textarea>
                    @error('treatment_summary')
                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Post-Discharge Instructions &
                        Follow-up</label>
                    <textarea name="instructions" rows="2"
                        placeholder="Rest at home for 3 days, follow-up in clinic in 2 weeks, continue prescribed medication..."
                        class="w-full px-3 py-2 bg-slate-50 border @error('instructions') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">{{ old('instructions') }}</textarea>
                    @error('instructions')
                        <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('admissions.show', $admission) }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold transition">Finalize
                        Discharge & Release Bed</button>
                </div>
            </form>
        </div>
    </div>
@endsection
