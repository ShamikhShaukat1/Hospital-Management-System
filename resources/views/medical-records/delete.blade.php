@extends('layouts.app')

@section('title', 'Delete Medical Record')
@section('page_title', 'Delete Medical Record')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl border border-rose-200 shadow-sm p-6 md:p-8">
            <div class="flex items-center gap-4 text-rose-600 mb-4 pb-4 border-b border-slate-100">
                <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Confirm Deletion</h3>
                    <p class="text-xs text-slate-500">Are you sure you want to permanently delete this medical record?</p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-4 mb-6 text-xs text-slate-700 space-y-2 border border-slate-200">
                <div class="flex justify-between">
                    <span class="font-semibold text-slate-500">Patient:</span>
                    <span class="font-bold text-slate-900">{{ $medicalRecord->patient->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-slate-500">Attending Doctor:</span>
                    <span class="font-semibold text-slate-800">Dr. {{ $medicalRecord->doctor->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-slate-500">Diagnosis:</span>
                    <span class="font-semibold text-teal-800">{{ $medicalRecord->diagnosis }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-slate-500">Record Date:</span>
                    <span>{{ \Carbon\Carbon::parse($medicalRecord->record_date)->format('M d, Y') }}</span>
                </div>
            </div>

            <p class="text-xs text-rose-600 mb-6">
                <i class="fas fa-info-circle mr-1"></i> This action cannot be undone. All clinical notes linked to this
                entry will be removed.
            </p>

            <form method="POST" action="{{ route('medical-records.destroy', $medicalRecord) }}"
                class="flex justify-end gap-3">
                @csrf
                @method('DELETE')

                <a href="{{ route('medical-records.index') }}"
                    class="px-4 py-2 border border-slate-300 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-semibold transition">
                    Yes, Delete Record
                </button>
            </form>
        </div>
    </div>
@endsection
