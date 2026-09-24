@extends('layouts.app')

@section('title', 'Appointments')
@section('page_title', 'Doctor Appointments & Visits')

@section('content')
    <div class="space-y-6">
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('appointments.index') }}"
                class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 sm:w-60">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search patient or doctor..."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <select name="status"
                    class="py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-700 focus:outline-none">
                    <option value="">All Statuses</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <input type="date" name="date" value="{{ request('date') }}"
                    class="py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-700 focus:outline-none">

                <button type="submit"
                    class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                    Filter</button>
                @if (request()->hasAny(['search', 'status', 'date']))
                    <a href="{{ route('appointments.index') }}" class="text-xs text-slate-500 underline">Reset</a>
                @endif
            </form>

            <a href="{{ route('appointments.create') }}"
                class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2">
                <i class="fas fa-calendar-plus"></i> Book Consultation
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                        <tr>
                            <th class="p-3.5 px-6">Appointment ID</th>
                            <th class="p-3.5 px-6">Patient</th>
                            <th class="p-3.5 px-6">Doctor & Dept</th>
                            <th class="p-3.5 px-6">Date & Time</th>
                            <th class="p-3.5 px-6">Reason</th>
                            <th class="p-3.5 px-6">Status</th>
                            <th class="p-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($appointments as $app)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3.5 px-6 font-mono font-bold text-teal-700">{{ $app->appointment_id }}</td>
                                <td class="p-3.5 px-6">
                                    <div class="font-bold text-slate-900">{{ $app->patient->name ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $app->patient->patient_id ?? '' }}
                                    </div>
                                </td>
                                <td class="p-3.5 px-6">
                                    <div class="font-semibold text-slate-800">Dr. {{ $app->doctor->name ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-500">
                                        {{ $app->department->name ?? ($app->doctor->department->name ?? '-') }}</div>
                                </td>
                                <td class="p-3.5 px-6">
                                    <div class="font-semibold text-slate-800">
                                        {{ $app->appointment_date->format('M d, Y') }}</div>
                                    <div class="text-slate-500 font-medium">
                                        {{ date('g:i A', strtotime($app->appointment_time)) }}</div>
                                </td>
                                <td class="p-3.5 px-6 max-w-xs truncate text-slate-600">{{ $app->reason }}</td>
                                <td class="p-3.5 px-6">
                                    @if ($app->status === 'Confirmed')
                                        <span
                                            class="px-2.5 py-1 font-semibold rounded-full bg-emerald-100 text-emerald-800">Confirmed</span>
                                    @elseif($app->status === 'Pending')
                                        <span
                                            class="px-2.5 py-1 font-semibold rounded-full bg-amber-100 text-amber-800">Pending</span>
                                    @elseif($app->status === 'Completed')
                                        <span
                                            class="px-2.5 py-1 font-semibold rounded-full bg-teal-100 text-teal-800">Completed</span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 font-semibold rounded-full bg-rose-100 text-rose-800">Cancelled</span>
                                    @endif
                                </td>
                                <td class="p-3.5 px-6 text-right space-x-1">
                                    <a href="{{ route('appointments.show', $app) }}"
                                        class="p-1.5 text-slate-400 hover:text-teal-700" title="View">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ route('appointments.edit', $app) }}"
                                        class="p-1.5 text-slate-400 hover:text-indigo-600" title="Edit">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="{{ route('appointments.delete', $app) }}"
                                        class="p-1.5 text-slate-400 hover:text-rose-600" title="Cancel/Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-400">No appointments logged yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($appointments->hasPages())
                <div class="p-4 border-t">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
