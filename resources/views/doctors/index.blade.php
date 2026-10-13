@extends('layouts.app')
@section('title', 'Doctors')
@section('page_title', 'Doctor & Specialist Directory')

@section('content')
    <div class="space-y-6">
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('doctors.index') }}"
                class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search doctor, ID, specialty..."
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <select name="department_id"
                    class="py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-700 focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    <option value="">All Departments</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                    Filter
                </button>
                @if (request()->hasAny(['search', 'department_id']))
                    <a href="{{ route('doctors.index') }}"
                        class="text-sm text-slate-500 hover:text-slate-800 underline">Reset</a>
                @endif
            </form>

            <a href="{{ route('doctors.create') }}"
                class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                <i class="fas fa-user-plus"></i> Add Doctor
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <th scope="col" class="px-6 py-3.5">Doctor</th>
                            <th scope="col" class="px-6 py-3.5">ID</th>
                            <th scope="col" class="px-6 py-3.5">Department</th>
                            <th scope="col" class="px-6 py-3.5">Consultation Fee</th>
                            <th scope="col" class="px-6 py-3.5">Contact</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($doctors as $doctor)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-base border border-teal-100 shrink-0">
                                            {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('doctors.show', $doctor) }}"
                                                class="font-bold text-slate-900 hover:text-teal-700 transition">
                                                {{ $doctor->name }}
                                            </a>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span
                                                    class="text-xs font-semibold text-teal-700 uppercase tracking-wider">{{ $doctor->specialization }}</span>
                                                @if ($doctor->qualification)
                                                    <span class="text-slate-300">•</span>
                                                    <span
                                                        class="text-xs text-slate-500">{{ $doctor->qualification }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-mono font-semibold rounded bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $doctor->doctor_id }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-slate-700 font-medium">
                                    {{ $doctor->department->name ?? 'General' }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap font-bold text-emerald-700">
                                    ${{ number_format($doctor->consultation_fee, 2) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                    {{ $doctor->phone }}
                                </td>

                                <td class="p-3.5 px-6 text-right space-x-2">
                                    <a href="{{ route('doctors.show', $doctor) }}"
                                        class="text-teal-700 hover:text-teal-900 font-semibold">View</a>
                                    </a>
                                    <a href="{{ route('doctors.edit', $doctor) }}"
                                        class="text-amber-600 hover:text-amber-800 font-semibold">Edit</a>
                                    </a>
                                    <a href="{{ route('doctors.delete', $doctor) }}"
                                        class="text-rose-600 hover:text-rose-800 font-semibold">Delete</a>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-slate-400">
                                    <i class="fas fa-user-md text-4xl mb-3 text-slate-300 block"></i>
                                    No doctor records match the criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($doctors->hasPages())
            <div class="bg-white p-4 rounded-xl border border-slate-200">
                {{ $doctors->links() }}
            </div>
        @endif
    </div>
@endsection
