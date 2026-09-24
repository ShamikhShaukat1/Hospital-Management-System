@extends('layouts.app')

@section('title', 'Invoice - ' . $invoice->invoice_number)
@section('page_title', 'Hospital Invoice Preview')

@section('content')
    <div class="max-w-3xl mx-auto space-y-4">
        <div class="no-print flex items-center justify-between bg-white p-4 rounded-xl border border-slate-200">
            <a href="{{ route('billing.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                &larr; Back to Invoices
            </a>
            <div class="space-x-2">
                @if ($invoice->status !== 'Paid')
                    <a href="{{ route('payments.create', ['invoice_id' => $invoice->id]) }}"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                        <i class="fas fa-hand-holding-dollar mr-1"></i> Collect Payment
                    </a>
                @endif
                <button onclick="window.print()"
                    class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm">
                    <i class="fas fa-print mr-1"></i> Print Invoice
                </button>
            </div>
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
                        <p class="text-xs text-slate-500">Department of Finance & Billing</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-xs uppercase font-bold text-slate-400">Invoice Number</div>
                    <div class="text-base font-mono font-bold text-teal-800">{{ $invoice->invoice_number }}</div>
                    <div class="text-xs text-slate-500 mt-1">Issue Date: {{ $invoice->invoice_date->format('F d, Y') }}
                    </div>
                    <span
                        class="inline-block mt-1 px-2.5 py-0.5 text-xs font-bold rounded-full {{ $invoice->status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : ($invoice->status === 'Partial' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                        {{ $invoice->status }}
                    </span>
                </div>
            </div>

            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs mb-6">
                <span class="text-slate-400 font-semibold uppercase block text-[10px]">Billed To</span>
                <span class="font-bold text-slate-800 text-sm block mt-0.5">{{ $invoice->patient->name ?? '-' }}</span>
                <span class="text-slate-600">Patient ID: {{ $invoice->patient->patient_id ?? '-' }} &bull; Phone:
                    {{ $invoice->patient->phone ?? '-' }}</span>
                @if ($invoice->admission)
                    <div class="text-teal-700 mt-1 font-medium">Inpatient Admission: {{ $invoice->admission->admission_id }}
                        (Room {{ $invoice->admission->room->room_number ?? '-' }})</div>
                @endif
            </div>

            <table class="w-full text-left text-xs mb-6">
                <thead class="border-b border-slate-200 text-slate-400 uppercase font-semibold">
                    <tr>
                        <th class="py-2.5">Item Description</th>
                        <th class="py-2.5 text-center">Qty</th>
                        <th class="py-2.5 text-right">Unit Price</th>
                        <th class="py-2.5 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td class="py-3 font-semibold text-slate-800">{{ $item->description }}</td>
                            <td class="py-3 text-center text-slate-600">{{ $item->quantity }}</td>
                            <td class="py-3 text-right text-slate-600">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="py-3 text-right font-bold text-slate-800">${{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @php
                $paidTotal = $invoice->payments->where('status', 'Success')->sum('amount');
                $balanceDue = max(0, $invoice->total - $paidTotal);
            @endphp
            <div class="border-t border-slate-200 pt-4 flex justify-end">
                <div class="w-64 space-y-1.5 text-xs">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal:</span>
                        <span class="font-semibold text-slate-800">${{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Discount:</span>
                        <span class="text-rose-600">-${{ number_format($invoice->discount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Tax:</span>
                        <span class="text-slate-800">+${{ number_format($invoice->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-slate-900 pt-2 border-t">
                        <span>Invoice Total:</span>
                        <span>${{ number_format($invoice->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-emerald-700 font-semibold">
                        <span>Amount Paid:</span>
                        <span>${{ number_format($paidTotal, 2) }}</span>
                    </div>
                    <div
                        class="flex justify-between text-sm font-bold {{ $balanceDue > 0 ? 'text-rose-700' : 'text-slate-500' }} pt-1 border-t">
                        <span>Balance Due:</span>
                        <span>${{ number_format($balanceDue, 2) }}</span>
                    </div>
                </div>
            </div>

            @if ($invoice->payments->count() > 0)
                <div class="mt-8 pt-6 border-t border-slate-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Recorded Payments</h4>
                    <div class="bg-slate-50 rounded-xl overflow-hidden border border-slate-200 text-xs">
                        <table class="w-full text-left">
                            <thead class="bg-slate-100 text-slate-600 font-semibold uppercase text-[10px]">
                                <tr>
                                    <th class="p-2.5">Receipt #</th>
                                    <th class="p-2.5">Date</th>
                                    <th class="p-2.5">Method</th>
                                    <th class="p-2.5 text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach ($invoice->payments as $payment)
                                    <tr>
                                        <td class="p-2.5 font-mono font-bold text-teal-800">{{ $payment->payment_id }}</td>
                                        <td class="p-2.5">{{ $payment->payment_date->format('M d, Y') }}</td>
                                        <td class="p-2.5">{{ $payment->payment_method }}</td>
                                        <td class="p-2.5 text-right font-bold text-emerald-700">
                                            ${{ number_format($payment->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="pt-10 mt-8 border-t border-slate-200 flex items-end justify-between text-xs text-slate-400">
                <div>Thank you for choosing CarePoint Hospital. Please keep this invoice for your medical insurance claims.
                </div>
                <div class="text-center w-40">
                    <div class="h-8 border-b border-slate-400 mb-1"></div>
                    <div class="font-bold text-slate-700 text-[11px]">Accounts Department</div>
                </div>
            </div>
        </div>
    </div>
@endsection
