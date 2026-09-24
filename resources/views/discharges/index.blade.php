@extends('layouts.app')

@section('title', 'Patient Discharges')
@section('page_title', 'Patient Discharges & Summaries')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <form method="GET" action="{{ route('discharges.index') }}" class="flex items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search discharge ID, patient..."
                    class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm w-64 focus:outline-none focus:ring-2 focus:ring-teal-600">
                <button type="submit"
                    class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                    Filter
                </button>
                @if (request('search'))
                    <a href="{{ route('discharges.index') }}"
                        class="text-xs text-slate-500 hover:text-slate-700 font-semibold underline">
                        Clear filter
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                    <tr>
                        <th class="p-3.5 px-6">Discharge ID</th>
                        <th class="p-3.5 px-6">Patient</th>
                        <th class="p-3.5 px-6">Doctor</th>
                        <th class="p-3.5 px-6">Discharge Date & Time</th>
                        <th class="p-3.5 px-6">Diagnosis</th>
                        <th class="p-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($discharges as $dis)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3.5 px-6 font-mono font-bold text-teal-700">{{ $dis->discharge_id }}</td>
                            <td class="p-3.5 px-6 font-bold text-slate-900">{{ $dis->patient->name ?? '-' }}</td>
                            <td class="p-3.5 px-6">Dr. {{ $dis->doctor->name ?? '-' }}</td>
                            <td class="p-3.5 px-6">
                                {{ optional($dis->discharge_date)->format('M d, Y') ?? '-' }}
                                @if ($dis->discharge_time)
                                    at {{ date('g:i A', strtotime($dis->discharge_time)) }}
                                @endif
                            </td>
                            <td class="p-3.5 px-6 font-medium text-slate-700">{{ $dis->diagnosis }}</td>
                            <td class="p-3.5 px-6 text-right">
                                <a href="{{ route('discharges.show', $dis) }}"
                                    class="px-3 py-1 bg-teal-50 text-teal-700 rounded font-semibold hover:bg-teal-100 transition">
                                    <i class="fas fa-print mr-1"></i> Summary Slip
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">No discharge summaries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($discharges->hasPages())
                <div class="p-4 border-t">{{ $discharges->links() }}</div>
            @endif
        </div>
    </div>
@endsection
