@extends('layouts.app')

@section('title', 'Medical Record')
@section('page_title', 'Clinical Record Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b">
            <div>
                <span class="text-xs text-slate-500">{{ $medicalRecord->record_date->format('F d, Y') }}</span>
                <h3 class="text-xl font-bold text-slate-900">{{ $medicalRecord->diagnosis }}</h3>
                <div class="text-xs text-slate-500 mt-0.5">Patient: <strong class="text-slate-800">{{ $medicalRecord->patient->name ?? '-' }}</strong> &bull; Attending: <strong>Dr. {{ $medicalRecord->doctor->name ?? '-' }}</strong></div>
            </div>
            <a href="{{ route('prescriptions.create', ['patient_id' => $medicalRecord->patient_id, 'medical_record_id' => $medicalRecord->id]) }}" class="px-3.5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-xs font-semibold">
                + Write Prescription
            </a>
        </div>

        <div class="space-y-4 text-sm">
            <div>
                <h4 class="text-xs font-bold uppercase text-slate-400">Clinical Symptoms</h4>
                <p class="text-slate-800 mt-1 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $medicalRecord->symptoms ?? 'None specified' }}</p>
            </div>
            <div>
                <h4 class="text-xs font-bold uppercase text-slate-400">Treatment Plan</h4>
                <p class="text-slate-800 mt-1 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $medicalRecord->treatment ?? 'None specified' }}</p>
            </div>
            @if($medicalRecord->notes)
            <div>
                <h4 class="text-xs font-bold uppercase text-slate-400">Doctor Notes</h4>
                <p class="text-slate-600 mt-1 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $medicalRecord->notes }}</p>
            </div>
            @endif
        </div>

        <div class="pt-4 border-t flex justify-between items-center text-xs">
            <a href="{{ route('medical-records.index') }}" class="text-slate-500 hover:underline">&larr; Back to Medical Records</a>
            <a href="{{ route('patients.show', $medicalRecord->patient_id) }}" class="text-teal-700 font-semibold hover:underline">View Patient File &rarr;</a>
        </div>
    </div>
</div>
@endsection
