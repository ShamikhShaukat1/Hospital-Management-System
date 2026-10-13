@extends('layouts.app')
@section('title', 'Hospital Departments')
@section('page_title', 'Hospital Departments & Wards')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <p class="text-sm text-slate-500">Manage clinical divisions, bed capacities, and assigned medical staff.</p>
            <a href="{{ route('departments.create') }}"
                class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-plus"></i> Add Department
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <th scope="col" class="px-6 py-3.5">Department</th>
                            <th scope="col" class="px-6 py-3.5">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-center">Doctors</th>
                            <th scope="col" class="px-6 py-3.5 text-center">Nurses</th>
                            <th scope="col" class="px-6 py-3.5 text-center">Rooms</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($departments as $dept)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-base border border-teal-100 shrink-0">
                                            <i class="fas fa-hospital"></i>
                                        </div>
                                        <div>
                                            <a href="{{ route('departments.show', $dept) }}"
                                                class="font-bold text-slate-900 hover:text-teal-700 transition">
                                                {{ $dept->name }}
                                            </a>
                                            <p class="text-xs text-slate-500 mt-0.5 line-clamp-1 max-w-md">
                                                {{ $dept->description ?? 'No description provided.' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $dept->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                        {{ ucfirst($dept->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center font-semibold text-slate-700">
                                    <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-800 text-xs">
                                        {{ $dept->doctors_count }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center font-semibold text-slate-700">
                                    <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-800 text-xs">
                                        {{ $dept->nurses_count }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center font-semibold text-slate-700">
                                    <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-800 text-xs">
                                        {{ $dept->rooms_count }}
                                    </span>
                                </td>

                                <td class="p-3.5 px-6 text-right space-x-2">
                                    <a href="{{ route('departments.show', $dept) }}"
                                        class="text-teal-700 hover:text-teal-900 font-semibold">View</a>

                                    </a>
                                    <a href="{{ route('departments.edit', $dept) }}"
                                        class="text-amber-600 hover:text-amber-800 font-semibold">Edit</a>

                                    </a>
                                    <a href="{{ route('departments.delete', $dept) }}"
                                        class="text-rose-600 hover:text-rose-800 font-semibold">Delete</a>

                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-slate-400">
                                    <i class="fas fa-hospital text-4xl mb-3 text-slate-300 block"></i>
                                    No departments configured yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if (isset($departments) && method_exists($departments, 'hasPages') && $departments->hasPages())
            <div class="bg-white p-4 rounded-xl border border-slate-200">
                {{ $departments->links() }}
            </div>
        @endif
    </div>
@endsection
