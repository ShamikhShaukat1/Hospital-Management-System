@extends('layouts.app')

@section('title', 'Delete Prescription')
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
                    <p class="text-xs text-slate-500">Are you sure you want to delete this prescription?</p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-4 text-xs space-y-2 border border-slate-200">
                <div class="flex justify-between">
                    <span class="text-slate-500">Rx Number:</span>
                    <span class="font-mono font-bold text-slate-900">{{ $prescription->prescription_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Patient:</span>
                    <span class="font-semibold text-slate-900">{{ $prescription->patient?->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Doctor:</span>
                    <span class="font-semibold text-slate-900">Dr. {{ $prescription->doctor?->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Date:</span>
                    <span
                        class="font-semibold text-slate-900">{{ $prescription->prescription_date?->format('M d, Y') }}</span>
                </div>
                <div class="pt-2 border-t text-slate-600">
                    <span class="font-semibold">Prescribed Items ({{ $prescription->items->count() }}):</span>
                    <ul class="list-disc list-inside mt-1 space-y-0.5 text-slate-500">
                        @foreach ($prescription->items as $item)
                            <li>{{ $item->medicine?->name ?? 'Medicine' }} - {{ $item->dosage }} ({{ $item->frequency }})
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <p class="text-xs text-rose-600 font-medium">
                <i class="fas fa-circle-info mr-1"></i> This action cannot be undone. Notifications will be sent to the
                assigned staff and patient.
            </p>

            <form method="POST" action="{{ route('prescriptions.destroy', $prescription) }}"
                class="flex justify-end gap-3 pt-2">
                @csrf
                @method('DELETE')

                <a href="{{ route('prescriptions.index') }}"
                    class="px-4 py-2 border rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                    class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-semibold shadow-sm flex items-center gap-2">
                    <i class="fas fa-trash-can"></i> Yes, Delete Prescription
                </button>
            </form>
        </div>
    </div>
@endsection
