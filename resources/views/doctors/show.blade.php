@extends('layouts.app')

@section('title', 'Doctor Profile - ' . $doctor->name)
@section('page_title', 'Doctor Profile & Consultations')

@section('content')
    <div class="space-y-6">
        <div
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div
                    class="w-16 h-16 rounded-2xl bg-teal-700 text-white flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($doctor->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $doctor->name }}</h2>
                    <div class="text-xs text-teal-700 font-bold uppercase tracking-wider">{{ $doctor->specialization }}
                        &bull; {{ $doctor->qualification }}</div>
                    <div class="text-xs text-slate-500 mt-1">
                        {{ $doctor->department->name ?? 'General' }} &bull; {{ $doctor->email }} &bull; {{ $doctor->phone }}
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span
                    class="text-lg font-bold text-emerald-700 px-3 py-1.5 bg-emerald-50 rounded-lg border border-emerald-200">
                    Fee: ${{ number_format($doctor->consultation_fee, 2) }}
                </span>
                <a href="{{ route('doctors.edit', $doctor) }}"
                    class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold">
                    Edit
                </a>
                <a href="{{ route('doctors.delete', $doctor) }}"
                    class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-semibold">
                    Delete
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <h4 class="font-bold text-slate-800 text-sm">Consultations & Scheduled Appointments
                    ({{ $doctor->appointments->count() }})</h4>
                <a href="{{ route('appointments.create', ['doctor_id' => $doctor->id]) }}"
                    class="text-xs font-semibold text-teal-700 hover:underline">+ Book Visit</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                        <tr>
                            <th class="p-3">Appointment ID</th>
                            <th class="p-3">Patient</th>
                            <th class="p-3">Date & Time</th>
                            <th class="p-3">Reason</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($doctor->appointments as $app)
                            <tr>
                                <td class="p-3 font-mono font-bold text-teal-700">{{ $app->appointment_id }}</td>
                                <td class="p-3 font-semibold text-slate-800">{{ $app->patient->name ?? '-' }}</td>
                                <td class="p-3">{{ $app->appointment_date->format('M d, Y') }} at
                                    {{ date('g:i A', strtotime($app->appointment_time)) }}</td>
                                <td class="p-3">{{ $app->reason }}</td>
                                <td class="p-3">
                                    <span
                                        class="px-2 py-0.5 rounded font-semibold {{ $app->status === 'Confirmed' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                                        {{ $app->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400">No appointments scheduled for this
                                    doctor.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
