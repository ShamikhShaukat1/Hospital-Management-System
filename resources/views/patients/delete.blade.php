@extends('layouts.app')

@section('title', 'Confirm Patient Deletion')
@section('page_title', 'Delete Patient Record')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <div class="bg-white rounded-2xl border border-rose-200 shadow-lg p-6 md:p-8 text-center">
        <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mx-auto mb-4 border border-rose-100">
            <i class="fas fa-trash-alt"></i>
        </div>

        <h3 class="text-xl font-bold text-slate-800">Confirm Deletion</h3>
        <p class="text-sm text-slate-600 mt-2">
            Are you sure you want to delete the record for patient <strong class="text-slate-900 font-semibold">{{ $patient->name }}</strong> (<span class="font-mono text-teal-700">{{ $patient->patient_id }}</span>)?
        </p>

        <div class="bg-slate-50 rounded-xl p-4 my-6 text-left text-xs text-slate-600 space-y-1.5 border border-slate-200">
            <div><strong class="text-slate-700">Gender & Age:</strong> {{ $patient->gender }}, {{ $patient->date_of_birth->age }} yrs (DOB: {{ $patient->date_of_birth->format('M d, Y') }})</div>
            <div><strong class="text-slate-700">Phone:</strong> {{ $patient->phone }}</div>
            <div><strong class="text-slate-700">Appointments:</strong> {{ $patient->appointments()->count() }} recorded</div>
            <div><strong class="text-slate-700">Medical Records:</strong> {{ $patient->medicalRecords()->count() }} recorded</div>
        </div>

        <p class="text-xs text-rose-600 font-medium mb-6">
            <i class="fas fa-triangle-exclamation mr-1"></i> This action performs a soft delete in compliance with hospital medical records retention policy.
        </p>

        <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="flex items-center justify-center gap-3">
            @csrf
            @method('DELETE')
            <a href="{{ route('patients.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-sm font-semibold transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold shadow-md shadow-rose-600/20 transition">
                Delete Permanently
            </button>
        </form>
    </div>
</div>
@endsection
