@extends('layouts.app')

@section('title', 'Financial Revenue Report')
@section('page_title', 'Hospital Financial & Billing Report')

@section('content')
    <div class="space-y-6">
        <div class="no-print bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <form method="GET" action="{{ route('reports.billing') }}" class="flex items-center gap-3">
                <select name="status" class="px-3 py-2 bg-slate-50 border rounded-lg text-sm">
                    <option value="">All Statuses</option>
                    <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Partial" {{ request('status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                    <option value="Unpaid" {{ request('status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="px-3 py-2 bg-slate-50 border rounded-lg text-sm">
                <span class="text-xs text-slate-400">to</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="px-3 py-2 bg-slate-50 border rounded-lg text-sm">
                <button type="submit"
                    class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-semibold">Filter</button>
            </form>

            <button onclick="window.print()"
                class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold flex items-center gap-2">
                <i class="fas fa-print"></i> Print Financial Audit
            </button>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-xl border border-slate-200">
                <span class="text-xs font-semibold text-slate-400 uppercase">Total Invoiced</span>
                <div class="text-xl font-bold text-slate-900 mt-1">${{ number_format($totalBilled, 2) }}</div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200">
                <span class="text-xs font-semibold text-slate-400 uppercase">Total Collected</span>
                @php $collected = $invoices->flatMap->payments->where('status', 'Success')->sum('amount'); @endphp
                <div class="text-xl font-bold text-emerald-700 mt-1">${{ number_format($collected, 2) }}</div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200">
                <span class="text-xs font-semibold text-slate-400 uppercase">Outstanding Receivables</span>
                <div class="text-xl font-bold text-rose-700 mt-1">${{ number_format(max(0, $totalBilled - $collected), 2) }}
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                    <tr>
                        <th class="p-3">Invoice #</th>
                        <th class="p-3">Patient</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Billed</th>
                        <th class="p-3">Discount</th>
                        <th class="p-3">Tax</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($invoices as $inv)
                        <tr>
                            <td class="p-3 font-mono font-bold text-teal-800">{{ $inv->invoice_number }}</td>
                            <td class="p-3 font-bold text-slate-800">{{ $inv->patient->name ?? '-' }}</td>
                            <td class="p-3">{{ $inv->invoice_date->format('M d, Y') }}</td>
                            <td class="p-3 font-bold text-slate-900">${{ number_format($inv->total, 2) }}</td>
                            <td class="p-3 text-rose-600">${{ number_format($inv->discount, 2) }}</td>
                            <td class="p-3 text-slate-600">${{ number_format($inv->tax, 2) }}</td>
                            <td class="p-3 font-semibold">{{ $inv->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-slate-400">No invoice records.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
