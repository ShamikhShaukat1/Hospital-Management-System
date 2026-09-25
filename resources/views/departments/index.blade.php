@extends('layouts.app')

@section('title', 'Hospital Departments')
@section('page_title', 'Hospital Departments & Wards')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Manage clinical divisions, bed capacities, and assigned medical staff.</p>
            <a href="{{ route('departments.create') }}"
                class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2">
                <i class="fas fa-plus"></i> Add Department
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($departments as $dept)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <div
                            class="w-10 h-10 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-lg">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <span
                            class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $dept->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                            {{ ucfirst($dept->status) }}
                        </span>
                    </div>

                    <h4 class="font-bold text-slate-800 text-base mb-1">{{ $dept->name }}</h4>
                    <p class="text-xs text-slate-500 mb-4 line-clamp-2">
                        {{ $dept->description ?? 'No description provided.' }}</p>

                    <div class="grid grid-cols-3 gap-2 py-3 border-t border-slate-100 text-center text-xs">
                        <div class="bg-slate-50 p-2 rounded-lg">
                            <div class="font-bold text-slate-800">{{ $dept->doctors_count }}</div>
                            <div class="text-[10px] text-slate-500 uppercase">Doctors</div>
                        </div>
                        <div class="bg-slate-50 p-2 rounded-lg">
                            <div class="font-bold text-slate-800">{{ $dept->nurses_count }}</div>
                            <div class="text-[10px] text-slate-500 uppercase">Nurses</div>
                        </div>
                        <div class="bg-slate-50 p-2 rounded-lg">
                            <div class="font-bold text-slate-800">{{ $dept->rooms_count }}</div>
                            <div class="text-[10px] text-slate-500 uppercase">Rooms</div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <a href="{{ route('departments.show', $dept) }}" class="font-bold text-teal-700 hover:underline">
                            View Staff & Rooms &rarr;
                        </a>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('departments.edit', $dept) }}"
                                class="text-slate-400 hover:text-amber-600 transition-colors" title="Edit Department">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="{{ route('departments.delete', $dept) }}"
                                class="text-slate-400 hover:text-rose-600 transition-colors" title="Delete Department">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-8 text-center text-slate-400">No departments configured yet.</div>
            @endforelse
        </div>
    </div>
@endsection
