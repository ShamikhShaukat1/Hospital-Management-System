@extends('layouts.app')

@section('title', 'Rx - ' . $prescription->prescription_id)
@section('page_title', 'Prescription Preview')

@section('content')
    <div class="max-w-3xl mx-auto space-y-4">

        <div class="no-print flex items-center justify-between bg-white p-4 rounded-xl border border-slate-200">
            <a href="{{ route('prescriptions.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                &larr; Back to Prescriptions
            </a>
            <button onclick="window.print()"
                class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2">
                <i class="fas fa-print"></i> Print Prescription
            </button>
        </div>

        <div class="bg-white rounded-2xl border border-slate-300 shadow-md p-8 md:p-12 print:border-none print:shadow-none">
            <div class="border-b-2 border-teal-800 pb-6 mb-6 flex items-start justify-between">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-teal-800 text-white flex items-center justify-center text-2xl font-bold">
                        <i class="fas fa-hospital-symbol"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight">CarePoint General Hospital</h2>
                        <p class="text-xs text-slate-500">742 Evergreen Terrace, Medical District &bull; Tel: (555) 019-2834
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-xs uppercase font-bold text-slate-400">Prescription No.</div>
                    <div class="text-base font-mono font-bold text-teal-800">{{ $prescription->prescription_id }}</div>
                    <div class="text-xs text-slate-500 mt-1">Date: {{ $prescription->prescription_date->format('F d, Y') }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs mb-8">
                <div>
                    <span class="text-slate-400 font-semibold uppercase block text-[10px]">Patient Details</span>
                    <span
                        class="font-bold text-slate-800 text-sm block mt-0.5">{{ $prescription->patient->name ?? '-' }}</span>
                    <span class="text-slate-600">ID: {{ $prescription->patient->patient_id ?? '-' }} &bull; Age:
                        {{ $prescription->patient->date_of_birth ? $prescription->patient->date_of_birth->age . ' yrs' : 'N/A' }}
                        &bull; Gender: {{ $prescription->patient->gender ?? '-' }}</span>
                </div>
                <div class="text-right">
                    <span class="text-slate-400 font-semibold uppercase block text-[10px]">Prescribing Physician</span>
                    <span class="font-bold text-slate-800 text-sm block mt-0.5">Dr.
                        {{ $prescription->doctor->name ?? '-' }}</span>
                    <span class="text-slate-600">{{ $prescription->doctor->specialization ?? '' }} &bull;
                        {{ $prescription->doctor->qualification ?? '' }}</span>
                </div>
            </div>

            <div class="text-3xl font-serif font-black text-teal-800 mb-4 tracking-tighter">
                &#8478;
            </div>

            <div class="mb-8">
                <table class="w-full text-left text-xs">
                    <thead class="border-b border-slate-200 text-slate-400 uppercase font-semibold">
                        <tr>
                            <th class="py-2.5">Medication & Form</th>
                            <th class="py-2.5">Dosage</th>
                            <th class="py-2.5">Frequency</th>
                            <th class="py-2.5">Duration</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($prescription->items as $item)
                            <tr>
                                <td class="py-3 font-bold text-slate-800 text-sm">
                                    {{ $item->medicine->name ?? 'Medicine' }}
                                    <span
                                        class="block text-xs font-normal text-slate-500">{{ $item->medicine->generic_name ?? '' }}
                                        ({{ $item->medicine->category ?? '' }})</span>
                                </td>
                                <td class="py-3 font-semibold text-slate-700">{{ $item->dosage }}</td>
                                <td class="py-3 text-slate-700">{{ $item->frequency }}</td>
                                <td class="py-3 text-slate-700">{{ $item->duration }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($prescription->instructions)
                <div class="p-4 bg-teal-50/50 rounded-xl border border-teal-100 mb-12 text-xs">
                    <span class="font-bold text-teal-900 uppercase tracking-wider block text-[10px] mb-1">Doctor's Advice &
                        Instructions</span>
                    <p class="text-teal-900 leading-relaxed">{{ $prescription->instructions }}</p>
                </div>
            @endif

            <div class="pt-8 border-t border-slate-200 flex items-end justify-between text-xs">
                <div class="text-slate-400 text-[11px]">
                    Valid for pharmacy dispensing &bull; System generated record
                </div>
                <div class="text-center w-48">
                    <div class="h-10 border-b border-slate-400 mb-2"></div>
                    <div class="font-bold text-slate-800">Dr. {{ $prescription->doctor->name ?? 'Physician' }}</div>
                    <div class="text-[11px] text-slate-500">Authorized Medical Signature</div>
                </div>
            </div>
        </div>
    </div>
@endsection
