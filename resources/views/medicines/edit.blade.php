@extends('layouts.app')

@section('title', 'Edit Medicine')
@section('page_title', 'Edit Medicine Inventory')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-800">
                    Edit Medicine <span class="text-teal-700 font-mono">({{ $medicine->medicine_id }})</span>
                </h3>
                <a href="{{ route('medicines.index') }}"
                    class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
                    <i class="fas fa-arrow-left"></i> Back to Inventory
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-lg text-xs text-rose-700">
                    <p class="font-bold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('medicines.update', $medicine) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Brand Name *</label>
                        <input type="text" name="name" value="{{ old('name', $medicine->name) }}" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Generic Name *</label>
                        <input type="text" name="generic_name" value="{{ old('generic_name', $medicine->generic_name) }}"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Category *</label>
                        <input type="text" name="category" value="{{ old('category', $medicine->category) }}"
                            placeholder="e.g. Antibiotic, Analgesic, Supplement" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Manufacturer *</label>
                        <input type="text" name="manufacturer" value="{{ old('manufacturer', $medicine->manufacturer) }}"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Stock Quantity *</label>
                        <input type="number" name="stock_quantity"
                            value="{{ old('stock_quantity', $medicine->stock_quantity) }}" min="0" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Unit Price ($) *</label>
                        <input type="number" step="0.01" name="unit_price"
                            value="{{ old('unit_price', $medicine->price ?? $medicine->unit_price) }}" min="0"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Expiry Date *</label>
                        <input type="date" name="expiry_date"
                            value="{{ old('expiry_date', $medicine->expiry_date?->format('Y-m-d')) }}" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Status *</label>
                        <select name="status" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="active" {{ old('status', $medicine->status) == 'active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="inactive"
                                {{ old('status', $medicine->status) == 'inactive' ? 'selected' : '' }}>Inactive /
                                Discontinued</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200">
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Description / Usage
                        Notes</label>
                    <textarea name="description" rows="3"
                        placeholder="Additional details, storage conditions, dosage recommendations..."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">{{ old('description', $medicine->description) }}</textarea>
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('medicines.index') }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                        Update Medicine
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
