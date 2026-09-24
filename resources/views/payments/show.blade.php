@extends('layouts.app')

@section('title', 'Payment Receipt - ' . $payment->payment_id)
@section('page_title', 'Payment Receipt')

@section('content')
    <div class="max-w-xl mx-auto space-y-4">
        <div class="no-print flex items-center justify-between bg-white p-4 rounded-xl border border-slate-200">
            <a href="{{ route('payments.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                &larr; Back to Payments
            </a>
            <button onclick="window.print()"
                class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center gap-2">
                <i class="fas fa-print"></i> Print Official Receipt
            </button>
        </div>

        <div class="bg-white rounded-2xl border border-slate-300 shadow-md p-8 print:border-none print:shadow-none">
            <div class="border-b-2 border-teal-800 pb-4 mb-4 text-center">
                <div
                    class="w-10 h-10 rounded-xl bg-teal-800 text-white flex items-center justify-center text-xl font-bold mx-auto mb-2">
                    <i class="fas fa-hospital-symbol"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900">CarePoint General Hospital</h3>
                <p class="text-xs text-slate-500">Official Payment Receipt Slip</p>
            </div>

            <div class="space-y-3 text-xs mb-6">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500">Receipt Number:</span>
                    <span class="font-mono font-bold text-teal-800">{{ $payment->payment_id }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500">Invoice Reference:</span>
                    <span class="font-mono font-bold text-slate-800">{{ $payment->invoice->invoice_number ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500">Patient Name:</span>
                    <span class="font-bold text-slate-800">{{ $payment->patient->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500">Date Received:</span>
                    <span class="text-slate-800">{{ $payment->payment_date->format('F d, Y') }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                    <span class="text-slate-500">Payment Method:</span>
                    <span class="text-slate-800 font-semibold">{{ $payment->payment_method }}</span>
                </div>
                @if ($payment->reference)
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-slate-500">Reference:</span>
                        <span class="text-slate-800">{{ $payment->reference }}</span>
                    </div>
                @endif
                <div class="flex justify-between items-center pt-2">
                    <span class="text-sm font-bold text-slate-900 uppercase">Amount Paid:</span>
                    <span class="text-xl font-bold text-emerald-700">${{ number_format($payment->amount, 2) }}</span>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-200 flex justify-between items-end text-[11px] text-slate-400">
                <div>Status: <strong class="text-emerald-700 uppercase">Paid in Full</strong></div>
                <div class="text-center">
                    <div class="w-32 border-b border-slate-400 mb-1"></div>
                    <div>Cashier Signature</div>
                </div>
            </div>
        </div>
    </div>
@endsection
