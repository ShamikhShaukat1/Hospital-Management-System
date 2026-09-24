@extends('layouts.app')

@section('title', 'Payments')
@section('page_title', 'Hospital Revenue & Payment Receipts')

@section('content')
    <div class="space-y-6">
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('payments.index') }}"
                class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search receipt #, patient..."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                </div>

                <select name="method"
                    class="py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-700">
                    <option value="">All Methods</option>
                    <option value="Cash" {{ request('method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="Credit Card" {{ request('method') == 'Credit Card' ? 'selected' : '' }}>Credit Card
                    </option>
                    <option value="Debit Card" {{ request('method') == 'Debit Card' ? 'selected' : '' }}>Debit Card</option>
                    <option value="Bank Transfer" {{ request('method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer
                    </option>
                    <option value="Insurance" {{ request('method') == 'Insurance' ? 'selected' : '' }}>Insurance</option>
                </select>

                <button type="submit"
                    class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                    Filter</button>
            </form>

            <a href="{{ route('payments.create') }}"
                class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2">
                <i class="fas fa-hand-holding-dollar"></i> Record New Payment
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                        <tr>
                            <th class="p-3.5 px-6">Receipt #</th>
                            <th class="p-3.5 px-6">Invoice #</th>
                            <th class="p-3.5 px-6">Patient</th>
                            <th class="p-3.5 px-6">Payment Method</th>
                            <th class="p-3.5 px-6">Date</th>
                            <th class="p-3.5 px-6">Amount Received</th>
                            <th class="p-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($payments as $pay)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3.5 px-6 font-mono font-bold text-teal-800">{{ $pay->payment_id }}</td>
                                <td class="p-3.5 px-6 font-mono text-slate-600">{{ $pay->invoice->invoice_number ?? '-' }}
                                </td>
                                <td class="p-3.5 px-6 font-bold text-slate-900">{{ $pay->patient->name ?? '-' }}</td>
                                <td class="p-3.5 px-6">
                                    <span
                                        class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold">{{ $pay->payment_method }}</span>
                                </td>
                                <td class="p-3.5 px-6">{{ $pay->payment_date->format('M d, Y') }}</td>
                                <td class="p-3.5 px-6 font-bold text-emerald-700">${{ number_format($pay->amount, 2) }}
                                </td>
                                <td class="p-3.5 px-6 text-right">
                                    <a href="{{ route('payments.show', $pay) }}"
                                        class="px-2.5 py-1 bg-teal-50 text-teal-700 rounded font-semibold hover:bg-teal-100">
                                        <i class="fas fa-print mr-1"></i> Receipt
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-400">No payment transactions recorded.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($payments->hasPages())
                <div class="p-4 border-t">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
