@extends('layouts.app')

@section('title', 'Patient Admissions')
@section('page_title', 'Inpatient Admissions')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <form method="GET" action="{{ route('admissions.index') }}" class="flex items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patient name, ID..."
                    class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm w-64">
                <select name="status" class="py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg text-sm">
                    <option value="">All Statuses</option>
                    <option value="Admitted" {{ request('status') == 'Admitted' ? 'selected' : '' }}>Admitted</option>
                    <option value="Discharged" {{ request('status') == 'Discharged' ? 'selected' : '' }}>Discharged</option>
                </select>
                <button type="submit"
                    class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                    Filter</button>
            </form>

            <a href="{{ route('admissions.create') }}"
                class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold flex items-center gap-2">
                <i class="fas fa-plus"></i> New Admission
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                    <tr>
                        <th class="p-3.5 px-6">Admission ID</th>
                        <th class="p-3.5 px-6">Patient</th>
                        <th class="p-3.5 px-6">Room & Bed</th>
                        <th class="p-3.5 px-6">Attending Doctor</th>
                        <th class="p-3.5 px-6">Date Admitted</th>
                        <th class="p-3.5 px-6">Status</th>
                        <th class="p-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($admissions as $adm)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3.5 px-6 font-mono font-bold text-teal-700">{{ $adm->admission_id }}</td>
                            <td class="p-3.5 px-6 font-bold text-slate-900">{{ $adm->patient->name ?? '-' }}</td>
                            <td class="p-3.5 px-6">
                                Room {{ $adm->room->room_number ?? '-' }} &bull; Bed {{ $adm->bed->bed_number ?? '-' }}
                            </td>
                            <td class="p-3.5 px-6">Dr. {{ $adm->doctor->name ?? '-' }}</td>
                            <td class="p-3.5 px-6">{{ $adm->admission_date->format('M d, Y') }}</td>
                            <td class="p-3.5 px-6">
                                <span
                                    class="px-2.5 py-0.5 rounded-full font-bold {{ $adm->status === 'Admitted' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $adm->status }}
                                </span>
                            </td>
                            <td class="p-3.5 px-6 text-right space-x-2">
                                <a href="{{ route('admissions.show', $adm) }}"
                                    class="text-teal-700 font-semibold hover:underline">View</a>
                                @if ($adm->status === 'Admitted')
                                    <a href="{{ route('discharges.create', ['admission_id' => $adm->id]) }}"
                                        class="px-2.5 py-1 bg-teal-50 text-teal-700 rounded font-semibold hover:bg-teal-100">
                                        Discharge
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">No admission records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($admissions->hasPages())
                <div class="p-4 border-t">{{ $admissions->links() }}</div>
            @endif
        </div>
    </div>
@endsection
