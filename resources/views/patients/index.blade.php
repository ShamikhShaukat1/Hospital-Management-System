@extends('layouts.app')

@section('title', 'Patients')
@section('page_title', 'Patient Directory')

@section('content')
    <div class="space-y-6">

        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('patients.index') }}"
                class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 sm:w-72">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search name, ID, phone, email..."
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-800 focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <select name="gender"
                    class="py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-700 focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    <option value="">All Genders</option>
                    <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>

                <select name="status"
                    class="py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-700 focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit"
                    class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                    Filter
                </button>
                @if (request()->hasAny(['search', 'gender', 'status']))
                    <a href="{{ route('patients.index') }}"
                        class="text-sm text-slate-500 hover:text-slate-800 underline">Reset</a>
                @endif
            </form>

            <a href="{{ route('patients.create') }}"
                class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                <i class="fas fa-plus"></i> Add New Patient
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead
                        class="bg-slate-50 text-slate-600 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-6">Patient ID</th>
                            <th class="py-3.5 px-6">Name & Blood Group</th>
                            <th class="py-3.5 px-6">Gender / DOB</th>
                            <th class="py-3.5 px-6">Contact Info</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($patients as $patient)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-6 font-mono font-semibold text-teal-800 text-xs">
                                    {{ $patient->patient_id }}
                                </td>
                                <td class="py-3.5 px-6">
                                    <div class="font-semibold text-slate-900">{{ $patient->name }}</div>
                                    @if ($patient->blood_group)
                                        <span
                                            class="inline-block mt-0.5 px-2 py-0.5 text-[10px] font-bold bg-rose-100 text-rose-800 rounded">
                                            {{ $patient->blood_group }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-6">
                                    <div>{{ $patient->gender }}</div>
                                    <div class="text-xs text-slate-500">{{ $patient->date_of_birth->format('M d, Y') }}
                                        ({{ $patient->date_of_birth->age }} yrs)
                                    </div>
                                </td>
                                <td class="py-3.5 px-6">
                                    <div class="text-slate-800">{{ $patient->phone }}</div>
                                    <div class="text-xs text-slate-500">{{ $patient->email ?? 'No email' }}</div>
                                </td>
                                <td class="py-3.5 px-6">
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $patient->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                                        {{ ucfirst($patient->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-right space-x-2">
                                    <a href="{{ route('patients.show', $patient) }}"
                                        class="p-1.5 text-slate-600 hover:text-teal-700 rounded hover:bg-slate-100"
                                        title="View Patient File">
                                        <i class="far fa-folder-open"></i>
                                    </a>
                                    <a href="{{ route('patients.edit', $patient) }}"
                                        class="p-1.5 text-slate-600 hover:text-indigo-600 rounded hover:bg-slate-100"
                                        title="Edit Patient">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="{{ route('patients.delete', $patient) }}"
                                        class="p-1.5 text-slate-600 hover:text-rose-600 rounded hover:bg-slate-100"
                                        title="Delete Patient">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-400">
                                    <i class="fas fa-user-slash text-3xl mb-2 text-slate-300 block"></i>
                                    No patient records found matching your query.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($patients->hasPages())
                <div class="p-4 border-t border-slate-200">
                    {{ $patients->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
