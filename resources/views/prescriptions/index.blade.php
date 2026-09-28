@extends('layouts.app')

@section('title', 'Prescriptions')
@section('page_title', 'Doctor Prescriptions')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <p class="text-sm text-slate-500">View and issue electronic prescriptions with automated pharmacy integration.
            </p>
            <a href="{{ route('prescriptions.create') }}"
                class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold flex items-center gap-2 w-fit">
                <i class="fas fa-prescription"></i> Write New Prescription
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                <form method="GET" action="{{ route('prescriptions.index') }}" class="flex gap-2 max-w-md">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search Rx # or patient name..."
                        class="w-full px-3 py-1.5 text-xs bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600">
                    <button type="submit"
                        class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                        Search
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                        <tr>
                            <th class="p-3.5 px-6">Rx Number</th>
                            <th class="p-3.5 px-6">Patient</th>
                            <th class="p-3.5 px-6">Doctor</th>
                            <th class="p-3.5 px-6">Date</th>
                            <th class="p-3.5 px-6">Medicines Prescribed</th>
                            <th class="p-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($prescriptions as $rx)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3.5 px-6 font-mono font-bold text-teal-700">{{ $rx->prescription_id }}</td>
                                <td class="p-3.5 px-6 font-bold text-slate-900">{{ $rx->patient->name ?? '-' }}</td>
                                <td class="p-3.5 px-6">Dr. {{ $rx->doctor->name ?? '-' }}</td>
                                <td class="p-3.5 px-6">{{ $rx->prescription_date?->format('M d, Y') }}</td>
                                <td class="p-3.5 px-6">
                                    <span
                                        class="px-2 py-1 bg-slate-100 rounded text-slate-700 font-semibold">{{ $rx->items->count() }}
                                        medications</span>
                                </td>
                                <td class="p-3.5 px-6 text-right space-x-1">
                                    <a href="{{ route('prescriptions.show', $rx) }}" title="View & Print"
                                        class="text-teal-700 hover:text-teal-900 font-semibold">View</a>
                                    </a>
                                    <a href="{{ route('prescriptions.edit', $rx) }}" title="Edit Prescription"
                                        class="text-amber-600 hover:text-amber-800 font-semibold">Edit</a>
                                    </a>
                                    <a href="{{ route('prescriptions.delete', $rx) }}" title="Delete Prescription"
                                        class="text-rose-600 hover:text-rose-800 font-semibold">Delete</a>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">No prescriptions recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($prescriptions->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $prescriptions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
