@extends('layouts.app')

@section('title', 'Medical Records')
@section('page_title', 'Clinical Diagnoses & Medical History')

@section('content')
    <div class="space-y-6">
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('medical-records.index') }}"
                class="flex items-center gap-3 w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patient, diagnosis..."
                    class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none w-64">
                <button type="submit"
                    class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                    Filter</button>
            </form>

            <a href="{{ route('medical-records.create') }}"
                class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold flex items-center gap-2">
                <i class="fas fa-plus"></i> New Medical Record
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                        <tr>
                            <th class="p-3.5 px-6">Record Date</th>
                            <th class="p-3.5 px-6">Patient</th>
                            <th class="p-3.5 px-6">Attending Doctor</th>
                            <th class="p-3.5 px-6">Diagnosis</th>
                            <th class="p-3.5 px-6">Treatment Plan</th>
                            <th class="p-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($medicalRecords as $record)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3.5 px-6 font-semibold text-slate-800">
                                    {{ $record->record_date->format('M d, Y') }}</td>
                                <td class="p-3.5 px-6 font-bold text-slate-900">{{ $record->patient->name ?? '-' }}</td>
                                <td class="p-3.5 px-6">Dr. {{ $record->doctor->name ?? '-' }}</td>
                                <td class="p-3.5 px-6 font-semibold text-teal-800">{{ $record->diagnosis }}</td>
                                <td class="p-3.5 px-6 max-w-xs truncate text-slate-500">
                                    {{ $record->treatment ?? 'Routine' }}</td>
                                <td class="p-3.5 px-6 text-right">
                                    <a href="{{ route('medical-records.show', $record) }}"
                                        class="text-teal-700 font-semibold hover:underline">
                                        View Full &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">No medical records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
