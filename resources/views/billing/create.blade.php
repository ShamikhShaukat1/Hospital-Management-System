@extends('layouts.app')

@section('title', 'Generate Invoice')
@section('page_title', 'Create Patient Medical Invoice')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 pb-3 mb-4 border-b">Hospital Invoice Formulation</h3>

            <form method="POST" action="{{ route('billing.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Patient *</label>
                        <select name="patient_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">-- Choose Patient --</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ old('patient_id', $selectedPatientId) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }} ({{ $patient->patient_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Inpatient Stay
                            (Optional)</label>
                        <select name="admission_id"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                            <option value="">-- Outpatient / Not Admitted --</option>
                            @foreach ($admissions as $adm)
                                <option value="{{ $adm->id }}" {{ old('admission_id') == $adm->id ? 'selected' : '' }}>
                                    {{ $adm->admission_id }} ({{ $adm->patient->name ?? '' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Invoice Date *</label>
                        <input type="date" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-teal-700">Billing Line Items</h4>
                        <button type="button" id="addItemBtn"
                            class="px-3 py-1.5 bg-teal-50 text-teal-700 hover:bg-teal-100 rounded-lg text-xs font-semibold">
                            <i class="fas fa-plus mr-1"></i> Add Line Item
                        </button>
                    </div>

                    <div id="itemsContainer" class="space-y-3">
                        <div
                            class="item-row p-3 rounded-lg bg-slate-50 border border-slate-200 grid grid-cols-1 md:grid-cols-6 gap-3">
                            <div class="md:col-span-3">
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Item Description
                                    *</label>
                                <input type="text" name="items[0][description]"
                                    placeholder="e.g. Doctor Consultation Fee, Lab Test, Bed Charge" required
                                    class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Quantity *</label>
                                <input type="number" name="items[0][quantity]" value="1" min="1" required
                                    class="qty-input w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Unit Price ($) *</label>
                                <input type="number" step="0.01" name="items[0][unit_price]" value="50.00"
                                    min="0" required
                                    class="price-input w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                            </div>
                            <div class="flex items-end justify-between">
                                <div class="text-xs font-bold text-slate-800 line-total pb-2">$50.00</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200 flex flex-col md:flex-row justify-between items-start gap-6">
                    <div class="w-full md:w-1/2 space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Discount ($)</label>
                            <input type="number" step="0.01" id="discountInput" name="discount"
                                value="{{ old('discount', '0.00') }}" min="0"
                                class="w-48 px-3 py-1.5 bg-slate-50 border border-slate-300 rounded text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Tax Amount ($)</label>
                            <input type="number" step="0.01" id="taxInput" name="tax"
                                value="{{ old('tax', '0.00') }}" min="0"
                                class="w-48 px-3 py-1.5 bg-slate-50 border border-slate-300 rounded text-xs">
                        </div>
                    </div>

                    <div class="w-full md:w-64 bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs space-y-2">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal:</span>
                            <span id="subtotalDisplay" class="font-semibold text-slate-800">$50.00</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Discount:</span>
                            <span id="discountDisplay" class="text-rose-600">-$0.00</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Tax:</span>
                            <span id="taxDisplay" class="text-slate-800">+$0.00</span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-slate-900 pt-2 border-t border-slate-200">
                            <span>Total Due:</span>
                            <span id="totalDisplay" class="text-emerald-700">$50.00</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('billing.index') }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm">Save
                        & Issue Invoice</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let itemIdx = 1;

        function recalculate() {
            let subtotal = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const qty = parseFloat(row.querySelector('.qty-input')?.value || 0);
                const price = parseFloat(row.querySelector('.price-input')?.value || 0);
                const line = qty * price;
                const lineEl = row.querySelector('.line-total');
                if (lineEl) lineEl.innerText = '$' + line.toFixed(2);
                subtotal += line;
            });

            const discount = parseFloat(document.getElementById('discountInput').value || 0);
            const tax = parseFloat(document.getElementById('taxInput').value || 0);
            const total = Math.max(0, subtotal - discount + tax);

            document.getElementById('subtotalDisplay').innerText = '$' + subtotal.toFixed(2);
            document.getElementById('discountDisplay').innerText = '-$' + discount.toFixed(2);
            document.getElementById('taxDisplay').innerText = '+$' + tax.toFixed(2);
            document.getElementById('totalDisplay').innerText = '$' + total.toFixed(2);
        }

        document.getElementById('addItemBtn').addEventListener('click', function() {
            const container = document.getElementById('itemsContainer');
            const row = document.createElement('div');
            row.className =
                'item-row p-3 rounded-lg bg-slate-50 border border-slate-200 grid grid-cols-1 md:grid-cols-6 gap-3';
            row.innerHTML = `
            <div class="md:col-span-3">
                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Item Description *</label>
                <input type="text" name="items[${itemIdx}][description]" placeholder="e.g. Service or Item" required 
                       class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Quantity *</label>
                <input type="number" name="items[${itemIdx}][quantity]" value="1" min="1" required 
                       class="qty-input w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Unit Price ($) *</label>
                <input type="number" step="0.01" name="items[${itemIdx}][unit_price]" value="10.00" min="0" required 
                       class="price-input w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
            </div>
            <div class="flex items-end justify-between">
                <div class="text-xs font-bold text-slate-800 line-total pb-2">$10.00</div>
                <button type="button" onclick="this.closest('.item-row').remove(); recalculate();" class="p-1.5 text-rose-500 hover:text-rose-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
            container.appendChild(row);
            itemIdx++;
            attachListeners(row);
            recalculate();
        });

        function attachListeners(context) {
            context.querySelectorAll('.qty-input, .price-input').forEach(input => {
                input.addEventListener('input', recalculate);
            });
        }

        attachListeners(document);
        document.getElementById('discountInput').addEventListener('input', recalculate);
        document.getElementById('taxInput').addEventListener('input', recalculate);
    </script>
@endsection
