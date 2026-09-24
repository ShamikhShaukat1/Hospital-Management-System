@extends('layouts.app')

@section('title', 'Admission - ' . $admission->admission_id)
@section('page_title', 'Inpatient Admission Record')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between pb-4 border-b">
                <div>
                    <span class="text-xs font-mono font-bold text-teal-700">{{ $admission->admission_id }}</span>
                    <h3 class="text-xl font-bold text-slate-800">{{ $admission->patient->name ?? 'Patient' }}</h3>
                    <p class="text-xs text-slate-500">Admitted on {{ $admission->admission_date->format('F d, Y') }}</p>
                </div>
                <div class="text-right">
                    <span
                        class="px-3 py-1 text-xs font-bold rounded-full {{ $admission->status === 'Admitted' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700' }}">
                        {{ $admission->status }}
                    </span>
                    @if ($admission->status === 'Admitted')
                        <div class="mt-2">
                            <a href="{{ route('discharges.create', ['admission_id' => $admission->id]) }}"
                                class="px-3 py-1.5 bg-teal-700 hover:bg-teal-800 text-white rounded text-xs font-semibold">
                                Discharge Patient
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-xs my-4">
                <div class="p-3 bg-slate-50 rounded-lg">
                    <span class="text-slate-400 font-semibold block uppercase">Room & Bed</span>
                    <span class="font-bold text-slate-800 text-sm">Room {{ $admission->room->room_number ?? '-' }} &bull;
                        Bed {{ $admission->bed->bed_number ?? '-' }}</span>
                    <div class="text-slate-500">{{ $admission->room->room_type ?? '' }}</div>
                </div>
                <div class="p-3 bg-slate-50 rounded-lg">
                    <span class="text-slate-400 font-semibold block uppercase">Attending Doctor</span>
                    <span class="font-bold text-slate-800 text-sm">Dr. {{ $admission->doctor->name ?? '-' }}</span>
                    <div class="text-slate-500">{{ $admission->doctor->specialization ?? '' }}</div>
                </div>
                <div class="col-span-2 p-3 bg-slate-50 rounded-lg">
                    <span class="text-slate-400 font-semibold block uppercase">Diagnosis</span>
                    <span class="font-semibold text-slate-800 text-sm block mt-0.5">{{ $admission->diagnosis }}</span>
                    <p class="text-slate-600 mt-1">Reason: {{ $admission->reason }}</p>
                </div>
            </div>

            @if ($admission->discharge)
                <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-200 text-xs">
                    <div class="font-bold text-emerald-900 mb-1">Discharge Summary
                        ({{ $admission->discharge->discharge_id }})</div>
                    <div class="text-emerald-800">Discharged on
                        {{ $admission->discharge->discharge_date->format('M d, Y') }} at
                        {{ date('g:i A', strtotime($admission->discharge->discharge_time)) }}</div>
                    <div class="text-emerald-700 mt-1 font-medium">{{ $admission->discharge->treatment_summary }}</div>
                </div>
            @endif

            <div class="pt-4 border-t flex justify-between items-center text-xs">
                <a href="{{ route('admissions.index') }}" class="text-slate-500 hover:underline">&larr; Back to
                    Admissions</a>
                <a href="{{ route('patients.show', $admission->patient_id) }}"
                    class="text-teal-700 font-semibold hover:underline">View Patient Medical File &rarr;</a>
            </div>
        </div>
    </div>
@endsection
