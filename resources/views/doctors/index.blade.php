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
                            {{ $dept->name }}</option>
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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($doctors as $doctor)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-lg border border-teal-100">
                                {{ strtoupper(substr($doctor->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-base leading-tight">{{ $doctor->name }}</h4>
                                <span
                                    class="text-xs font-semibold text-teal-700 uppercase tracking-wider block mt-0.5">{{ $doctor->specialization }}</span>
                                <span class="text-[11px] text-slate-500">{{ $doctor->qualification }}</span>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 text-[11px] font-mono font-semibold rounded bg-slate-100 text-slate-700">
                            {{ $doctor->doctor_id }}
                        </span>
                    </div>

                    <div class="my-4 pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-600">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Department:</span>
                            <span class="font-medium text-slate-800">{{ $doctor->department->name ?? 'General' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Fee:</span>
                            <span
                                class="font-bold text-emerald-700">${{ number_format($doctor->consultation_fee, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Contact:</span>
                            <span class="font-medium text-slate-800">{{ $doctor->phone }}</span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('doctors.show', $doctor) }}"
                            class="text-xs font-bold text-teal-700 hover:text-teal-900">
                            View Schedule & Profile &rarr;
                        </a>
                        <div class="space-x-1">
                            <a href="{{ route('doctors.edit', $doctor) }}"
                                class="p-1.5 text-slate-400 hover:text-indigo-600 rounded hover:bg-slate-100">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="{{ route('doctors.delete', $doctor) }}"
                                class="p-1.5 text-slate-400 hover:text-rose-600 rounded hover:bg-slate-100">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl p-12 text-center text-slate-400">
                    <i class="fas fa-user-md text-4xl mb-3 text-slate-300 block"></i>
                    No doctor records match the criteria.
                </div>
            @endforelse
        </div>

        @if ($doctors->hasPages())
            <div class="bg-white p-4 rounded-xl border border-slate-200">
                {{ $doctors->links() }}
            </div>
        @endif

    </div>
@endsection
