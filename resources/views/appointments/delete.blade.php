@extends('layouts.app')

@section('title', 'Delete Appointment')
@section('page_title', 'Cancel / Delete Appointment')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <div class="bg-white rounded-2xl border border-rose-200 shadow-lg p-6 md:p-8 text-center">
        <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mx-auto mb-4 border border-rose-100">
            <i class="far fa-calendar-times"></i>
        </div>

        <h3 class="text-xl font-bold text-slate-800">Cancel / Remove Appointment</h3>
        <p class="text-sm text-slate-600 mt-2">
            Are you sure you want to cancel appointment <span class="font-mono text-teal-700 font-bold">{{ $appointment->appointment_id }}</span> for <strong>{{ $appointment->patient->name ?? 'Patient' }}</strong>?
        </p>

        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" class="flex items-center justify-center gap-3 mt-6">
            @csrf
            @method('DELETE')
            <a href="{{ route('appointments.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-sm font-semibold transition">
                Keep Appointment
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold shadow-md shadow-rose-600/20 transition">
                Confirm Cancellation
            </button>
        </form>
    </div>
</div>
@endsection
