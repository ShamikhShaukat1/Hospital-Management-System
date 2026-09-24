@extends('layouts.app')

@section('title', 'Record Payment')
@section('page_title', 'Record Hospital Payment')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
        <h3 class="text-lg font-bold text-slate-800 pb-3 mb-4 border-b">Payment Receipt Form</h3>

        <form method="POST" action="{{ route('payments.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Select Pending Invoice *</label>
                <select name="invoice_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    <option value="">-- Choose Invoice to Pay --</option>
                    @foreach($invoices as $inv)
                        @php $due = max(0, $inv->total - $inv->payments->where('status', 'Success')->sum('amount')); @endphp
                        <option value="{{ $inv->id }}" {{ (old('invoice_id', request('invoice_id')) == $inv->id) ? 'selected' : '' }}>
                            {{ $inv->invoice_number }} &bull; {{ $inv->patient->name ?? 'Patient' }} &bull; Due: ${{ number_format($due, 2) }} (Status: {{ $inv->status }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Amount to Collect ($) *</label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" placeholder="0.00" min="0.01" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Payment Method *</label>
                    <select name="payment_method" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="Cash">Cash</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Debit Card">Debit Card</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Insurance">Insurance / Third Party</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Payment Date *</label>
                    <input type="date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Transaction Ref / Cheque #</label>
                    <input type="text" name="reference" value="{{ old('reference') }}" placeholder="Optional transaction ID or approval code" 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                </div>
            </div>

            <div class="pt-4 border-t flex justify-end gap-2">
                <a href="{{ route('payments.index') }}" class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm">Process Payment</button>
            </div>
        </form>
    </div>
</div>
@endsection
