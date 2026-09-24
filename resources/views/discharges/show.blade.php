@extends('layouts.app')

@section('title', 'Discharge Summary - ' . $discharge->discharge_id)
@section('page_title', 'Hospital Discharge Summary')

@section('content')
    <style>
        @media print {
            body {
                background: white !important;
            }

            .no-print {
                display: none !important;
            }

            .print-card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
        }
    </style>

    <div class="max-w-3xl mx-auto space-y-4">
        @if (session('success'))
            <div
                class="no-print bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center justify-between">
                <div>{{ session('success') }}</div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
            </div>
        @endif

        <div class="no-print flex items-center justify-between bg-white p-4 rounded-xl border border-slate-200">
            <a href="{{ route('discharges.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                &larr; Back to Discharges
            </a>
            <button onclick="window.print()"
                class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2 transition">
                <i class="fas fa-print"></i> Print Discharge Summary
            </button>
        </div>

        <div class="print-card bg-white rounded-2xl border border-slate-300 shadow-md p-8 md:p-12">
            <div class="border-b-2 border-teal-800 pb-6 mb-6 flex items-start justify-between">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-teal-800 text-white flex items-center justify-center text-2xl font-bold">
                        <i class="fas fa-hospital-symbol"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight">CarePoint General Hospital</h2>
                        <p class="text-xs text-slate-500">Inpatient Discharge Summary & Certification</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-xs uppercase font-bold text-slate-400">Discharge Slip No.</div>
                    <div class="text-base font-mono font-bold text-teal-800">{{ $discharge->discharge_id }}</div>
                    <div class="text-xs text-slate-500 mt-1">
                        Date: {{ optional($discharge->discharge_date)->format('F d, Y') ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs mb-6">
                <div>
                    <span class="text-slate-400 font-semibold uppercase block text-[10px]">Patient Information</span>
                    <span
                        class="font-bold text-slate-800 text-sm block mt-0.5">{{ $discharge->patient->name ?? '-' }}</span>
                    <span class="text-slate-600">ID: {{ $discharge->patient->patient_id ?? '-' }} &bull; Gender:
                        {{ $discharge->patient->gender ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold uppercase block text-[10px]">Attending Physician</span>
                    <span class="font-bold text-slate-800 text-sm block mt-0.5">Dr.
                        {{ $discharge->doctor->name ?? '-' }}</span>
                    <span class="text-slate-600">{{ $discharge->doctor->department->name ?? 'General Medicine' }}</span>
                </div>
            </div>

            <div class="space-y-5 text-xs text-slate-800 mb-12">
                <div>
                    <h4 class="font-bold uppercase text-[11px] text-teal-800 mb-1">Final Clinical Diagnosis</h4>
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 font-semibold text-slate-900">
                        {{ $discharge->diagnosis }}
                    </div>
                </div>

                <div>
                    <h4 class="font-bold uppercase text-[11px] text-teal-800 mb-1">Hospital Treatment & Course Summary</h4>
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 leading-relaxed text-slate-700">
                        {{ $discharge->treatment_summary }}
                    </div>
                </div>

                @if ($discharge->instructions)
                    <div>
                        <h4 class="font-bold uppercase text-[11px] text-teal-800 mb-1">Discharge Advice & Follow-Up</h4>
                        <div class="p-3 bg-teal-50/50 rounded-lg border border-teal-100 leading-relaxed text-teal-900">
                            {{ $discharge->instructions }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="pt-8 border-t border-slate-200 flex items-end justify-between text-xs">
                <div class="text-slate-400 text-[11px]">
                    Hospital Medical Records Archive Copy &bull; Status: {{ $discharge->status }}
                </div>
                <div class="text-center w-48">
                    <div class="h-10 border-b border-slate-400 mb-2"></div>
                    <div class="font-bold text-slate-800">Dr. {{ $discharge->doctor->name ?? 'Attending Doctor' }}</div>
                    <div class="text-[11px] text-slate-500">Physician In-Charge</div>
                </div>
            </div>
        </div>
    </div>
@endsection
