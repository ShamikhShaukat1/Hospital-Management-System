@extends('layouts.app')

@section('title', 'Patient Report')
@section('page_title', 'Patient Population Report')

@section('content')
<div class="space-y-6">
    <div class="no-print bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <form method="GET" action="{{ route('reports.patients') }}" class="flex items-center gap-3">
            <select name="gender" class="px-3 py-2 bg-slate-50 border rounded-lg text-sm">
                <option value="">All Genders</option>
                <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="px-3 py-2 bg-slate-50 border rounded-lg text-sm">
            <span class="text-xs text-slate-400">to</span>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="px-3 py-2 bg-slate-50 border rounded-lg text-sm">
            <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-semibold">Filter</button>
        </form>

        <button onclick="window.print()" class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold flex items-center gap-2">
            <i class="fas fa-print"></i> Print Report
        </button>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="print-only hidden mb-6 pb-4 border-b">
            <h2 class="text-xl font-bold">CarePoint General Hospital - Patient Demographics Report</h2>
            <p class="text-xs text-slate-500">Generated on {{ date('F d, Y') }}</p>
        </div>

        <div class="mb-4 text-xs font-semibold text-slate-500">
            Total Records Found: <strong class="text-slate-800">{{ $patients->count() }}</strong>
        </div>

        <table class="w-full text-left text-xs text-slate-700">
            <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                <tr>
                    <th class="p-3">Patient ID</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Gender / Age</th>
                    <th class="p-3">Blood Group</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">Registered Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($patients as $p)
                    <tr>
                        <td class="p-3 font-mono font-bold text-teal-800">{{ $p->patient_id }}</td>
                        <td class="p-3 font-bold text-slate-900">{{ $p->name }}</td>
                        <td class="p-3">{{ $p->gender }} ({{ $p->date_of_birth ? $p->date_of_birth->age : '-' }} yrs)</td>
                        <td class="p-3">{{ $p->blood_group ?? '-' }}</td>
                        <td class="p-3">{{ $p->phone }}</td>
                        <td class="p-3">{{ $p->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-slate-400">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
