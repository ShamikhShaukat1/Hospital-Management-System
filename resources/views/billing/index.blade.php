@extends('layouts.app')

@section('title', 'Billing & Invoices')
@section('page_title', 'Hospital Invoices & Billing')

@section('content')
    <div class="space-y-6">
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('billing.index') }}"
                class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search invoice #, patient..."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                </div>

                <select name="status"
                    class="py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-700">
                    <option value="">All Statuses</option>
                    <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Partial" {{ request('status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                    <option value="Unpaid" {{ request('status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>

                <button type="submit"
                    class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                    Filter</button>
                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('billing.index') }}" class="text-xs text-slate-500 underline">Reset</a>
                @endif
            </form>

            <a href="{{ route('billing.create') }}"
                class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2">
                <i class="fas fa-file-invoice-dollar"></i> Generate New Invoice
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                        <tr>
                            <th class="p-3.5 px-6">Invoice #</th>
                            <th class="p-3.5 px-6">Patient</th>
                            <th class="p-3.5 px-6">Invoice Date</th>
                            <th class="p-3.5 px-6">Total Amount</th>
                            <th class="p-3.5 px-6">Paid Amount</th>
                            <th class="p-3.5 px-6">Balance Due</th>
                            <th class="p-3.5 px-6">Status</th>
                            <th class="p-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($invoices as $inv)
                            @php
                                $paid = $inv->payments->where('status', 'Success')->sum('amount');
                                $due = max(0, $inv->total - $paid);
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="p-3.5 px-6 font-mono font-bold text-teal-800">{{ $inv->invoice_number }}</td>
                                <td class="p-3.5 px-6">
                                    <div class="font-bold text-slate-900">{{ $inv->patient->name ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $inv->patient->patient_id ?? '' }}
                                    </div>
                                </td>
                                <td class="p-3.5 px-6">{{ $inv->invoice_date->format('M d, Y') }}</td>
                                <td class="p-3.5 px-6 font-bold text-slate-800">${{ number_format($inv->total, 2) }}</td>
                                <td class="p-3.5 px-6 font-semibold text-emerald-700">${{ number_format($paid, 2) }}</td>
                                <td class="p-3.5 px-6 font-semibold {{ $due > 0 ? 'text-rose-600' : 'text-slate-400' }}">
                                    ${{ number_format($due, 2) }}</td>
                                <td class="p-3.5 px-6">
                                    @if ($inv->status === 'Paid')
                                        <span
                                            class="px-2.5 py-0.5 rounded-full font-bold bg-emerald-100 text-emerald-800">Paid</span>
                                    @elseif($inv->status === 'Partial')
                                        <span
                                            class="px-2.5 py-0.5 rounded-full font-bold bg-amber-100 text-amber-800">Partial</span>
                                    @else
                                        <span
                                            class="px-2.5 py-0.5 rounded-full font-bold bg-rose-100 text-rose-800">Unpaid</span>
                                    @endif
                                </td>
                                <td class="p-3.5 px-6 text-right space-x-2">
                                    <a href="{{ route('billing.show', $inv) }}"
                                        class="text-teal-700 font-semibold hover:underline">
                                        <i class="fas fa-print mr-1"></i> View / Pay
                                    </a>
                                    @if ($inv->status !== 'Paid')
                                        <a href="{{ route('payments.create', ['invoice_id' => $inv->id]) }}"
                                            class="px-2 py-1 bg-teal-700 text-white rounded font-semibold hover:bg-teal-800">
                                            Collect
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-slate-400">No invoices recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($invoices->hasPages())
                <div class="p-4 border-t">{{ $invoices->links() }}</div>
            @endif
        </div>

    </div>
@endsection
