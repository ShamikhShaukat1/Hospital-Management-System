@extends('layouts.app')

@section('title', $department->name . ' Department')
@section('page_title', $department->name . ' Department')

@section('content')
    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ $department->name }}</h2>
                <p class="text-sm text-slate-500 mt-1">{{ $department->description }}</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route('departments.index') }}"
                    class="px-4 py-2 border rounded-lg text-xs font-semibold text-slate-700">Back</a>
                <a href="{{ route('departments.delete', $department) }}"
                    class="px-4 py-2 bg-rose-50 text-rose-700 rounded-lg text-xs font-semibold">Delete</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <h4 class="font-bold text-slate-800 text-sm mb-3">Doctors in this Department
                    ({{ $department->doctors->count() }})</h4>
                <div class="divide-y divide-slate-100 text-xs">
                    @forelse($department->doctors as $doc)
                        <div class="py-2.5 flex items-center justify-between">
                            <div>
                                <div class="font-semibold text-slate-800">{{ $doc->name }}</div>
                                <div class="text-slate-500">{{ $doc->specialization }} &bull; {{ $doc->phone }}</div>
                            </div>
                            <a href="{{ route('doctors.show', $doc) }}"
                                class="text-teal-700 font-semibold hover:underline">View Profile</a>
                        </div>
                    @empty
                        <div class="py-4 text-center text-slate-400">No doctors assigned.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <h4 class="font-bold text-slate-800 text-sm mb-3">Nursing Staff ({{ $department->nurses->count() }})</h4>
                <div class="divide-y divide-slate-100 text-xs">
                    @forelse($department->nurses as $nurse)
                        <div class="py-2.5 flex items-center justify-between">
                            <div>
                                <div class="font-semibold text-slate-800">{{ $nurse->name }}</div>
                                <div class="text-slate-500">{{ $nurse->qualification }} &bull; {{ $nurse->phone }}</div>
                            </div>
                            <span class="text-emerald-700 font-medium">Active</span>
                        </div>
                    @empty
                        <div class="py-4 text-center text-slate-400">No nurses assigned.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
