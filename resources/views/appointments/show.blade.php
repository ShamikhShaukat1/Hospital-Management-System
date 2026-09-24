@extends('layouts.app')

@section('title', 'Appointment - ' . $appointment->appointment_id)
@section('page_title', 'Appointment Details')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
            <div class="flex items-center justify-between pb-4 border-b">
                <div>
                    <span class="text-xs font-bold text-teal-700 font-mono">{{ $appointment->appointment_id }}</span>
                    <h3 class="text-xl font-bold text-slate-800">{{ $appointment->patient->name ?? 'Patient' }}</h3>
                </div>
                <span
                    class="px-3 py-1 font-semibold rounded-full text-xs {{ $appointment->status === 'Confirmed' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-800' }}">
                    {{ $appointment->status }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <div class="text-xs text-slate-400 font-semibold uppercase">Doctor</div>
                    <div class="font-bold text-slate-800">Dr. {{ $appointment->doctor->name ?? '-' }}</div>
                    <div class="text-xs text-slate-500">{{ $appointment->doctor->specialization ?? '' }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-semibold uppercase">Schedule</div>
                    <div class="font-bold text-slate-800">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                    <div class="text-xs text-slate-500">{{ date('g:i A', strtotime($appointment->appointment_time)) }}</div>
                </div>
                <div class="col-span-2">
                    <div class="text-xs text-slate-400 font-semibold uppercase">Reason for Consultation</div>
                    <div class="text-slate-800 mt-0.5">{{ $appointment->reason }}</div>
                </div>
                @if ($appointment->notes)
                    <div class="col-span-2">
                        <div class="text-xs text-slate-400 font-semibold uppercase">Notes</div>
                        <div class="text-slate-600 mt-0.5">{{ $appointment->notes }}</div>
                    </div>
                @endif
            </div>

            <div class="pt-4 border-t flex items-center justify-between">
                <a href="{{ route('appointments.index') }}" class="text-xs text-slate-500 hover:underline">&larr; Back to
                    list</a>
                <div class="space-x-2">
                    <a href="{{ route('medical-records.create', ['patient_id' => $appointment->patient_id, 'appointment_id' => $appointment->id]) }}"
                        class="px-3 py-1.5 bg-slate-800 text-white rounded text-xs font-semibold">
                        Log Medical Record
                    </a>
                    <a href="{{ route('appointments.edit', $appointment) }}"
                        class="px-3 py-1.5 border rounded text-xs font-semibold text-slate-700">
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
