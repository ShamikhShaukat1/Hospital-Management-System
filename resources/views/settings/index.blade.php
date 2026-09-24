@extends('layouts.app')

@section('title', 'Hospital Settings')
@section('page_title', 'Hospital System Settings')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
        <h3 class="text-lg font-bold text-slate-800 pb-3 mb-6 border-b">Hospital Profile & Billing Configuration</h3>

        <form method="POST" action="{{ route('settings.update') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Hospital / Clinic Name *</label>
                <input type="text" name="hospital_name" value="{{ old('hospital_name', $settings['hospital_name']) }}" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Official Email Address *</label>
                    <input type="email" name="hospital_email" value="{{ old('hospital_email', $settings['hospital_email']) }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Phone Number *</label>
                    <input type="text" name="hospital_phone" value="{{ old('hospital_phone', $settings['hospital_phone']) }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Physical Address *</label>
                <textarea name="hospital_address" rows="2" required 
                          class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">{{ old('hospital_address', $settings['hospital_address']) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t">
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Tax Percentage (%) *</label>
                    <input type="number" step="0.1" name="tax_percentage" value="{{ old('tax_percentage', $settings['tax_percentage']) }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Currency Symbol *</label>
                    <input type="text" name="currency_symbol" value="{{ old('currency_symbol', $settings['currency_symbol']) }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Emergency Hotline *</label>
                    <input type="text" name="emergency_hotline" value="{{ old('emergency_hotline', $settings['emergency_hotline']) }}" required 
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                </div>
            </div>

            <div class="pt-6 border-t flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm">
                    Save Hospital Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
