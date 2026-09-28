@extends('layouts.app')

@section('title', 'Delete Admission')
@section('page_title', 'Confirm Deletion')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-xl border border-rose-200 shadow-sm p-6 md:p-8 space-y-6">
            <div class="flex items-center gap-4 text-rose-600 border-b border-rose-100 pb-4">
                <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-triangle-exclamation text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Confirm Deletion</h3>
                    <p class="text-xs text-slate-500">Are you sure you want to remove this admission record?</p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-4 text-xs space-y-2 border border-slate-200">
                <div class="flex justify-between">
                    <span class="text-slate-500">Admission ID:</span>
                    <span class="font-mono font-bold text-slate-900">{{ $admission->admission_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Patient:</span>
                    <span class="font-bold text-slate-900">{{ $admission->patient->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Attending Doctor:</span>
                    <span class="font-semibold text-slate-700">Dr. {{ $admission->doctor->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Room & Bed:</span>
                    <span class="font-semibold text-slate-700">Room {{ $admission->room->room_number ?? '-' }}, Bed
                        {{ $admission->bed->bed_number ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Admission Date:</span>
                    <span class="font-semibold text-slate-700">{{ $admission->admission_date?->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Status:</span>
                    <span class="font-bold text-amber-700">{{ $admission->status }}</span>
                </div>
            </div>

            <p class="text-xs text-rose-600 font-medium">
                <i class="fas fa-circle-info mr-1"></i> Removing this record will free up the assigned bed if currently
                marked as occupied. Notifications will be dispatched to staff members.
            </p>

            <form method="POST" action="{{ route('admissions.destroy', $admission) }}" class="flex justify-end gap-3 pt-2">
                @csrf
                @method('DELETE')

                <a href="{{ route('admissions.index') }}"
                    class="px-4 py-2 border rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                    class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-semibold shadow-sm flex items-center gap-2">
                    <i class="fas fa-trash-can"></i> Yes, Remove Admission
                </button>
            </form>
        </div>
    </div>
@endsection
