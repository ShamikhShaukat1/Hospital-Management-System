@extends('layouts.app')

@section('title', 'Add Medicine')
@section('page_title', 'Register Medicine Item')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
        <h3 class="text-lg font-bold text-slate-800 pb-3 mb-4 border-b">Pharmacy Item Form</h3>

        <form method="POST" action="{{ route('medicines.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Brand Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Amoxil 500mg" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Generic Name *</label>
                    <input type="text" name="generic_name" value="{{ old('generic_name') }}" placeholder="e.g. Amoxicillin Trihydrate" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Category *</label>
                    <input type="text" name="category" value="{{ old('category') }}" placeholder="e.g. Antibiotics, Analgesics, Antipyretics" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Stock Quantity *</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 100) }}" min="0" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Price per Unit ($) *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', '12.50') }}" min="0" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Expiry Date *</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Item Description / Storage Notes</label>
                    <textarea name="description" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t flex justify-end gap-2">
                <a href="{{ route('medicines.index') }}" class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold">Save Medicine</button>
            </div>
        </form>
    </div>
</div>
@endsection
