@extends('layouts.app')

@section('title', $medicine->name . ' - Pharmacy')
@section('page_title', 'Medicine Inventory Details')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b">
            <div>
                <span class="text-xs uppercase font-bold text-teal-700">{{ $medicine->category }}</span>
                <h3 class="text-xl font-bold text-slate-800">{{ $medicine->name }}</h3>
                <p class="text-xs text-slate-500">Generic: {{ $medicine->generic_name }}</p>
            </div>
            <div class="text-right">
                <div class="text-xl font-bold text-emerald-700">${{ number_format($medicine->price, 2) }}</div>
                <div class="text-xs text-slate-500">per unit</div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-xs">
            <div class="p-3 bg-slate-50 rounded-lg">
                <span class="text-slate-400 font-semibold block uppercase">Current Stock Level</span>
                <span class="text-lg font-bold {{ $medicine->stock_quantity <= 20 ? 'text-rose-600' : 'text-slate-800' }}">
                    {{ $medicine->stock_quantity }} units
                </span>
            </div>
            <div class="p-3 bg-slate-50 rounded-lg">
                <span class="text-slate-400 font-semibold block uppercase">Expiry Date</span>
                <span class="text-base font-semibold text-slate-800">
                    {{ $medicine->expiry_date->format('M d, Y') }}
                </span>
            </div>
            @if($medicine->description)
                <div class="col-span-2 p-3 bg-slate-50 rounded-lg">
                    <span class="text-slate-400 font-semibold block uppercase">Description & Storage</span>
                    <p class="text-slate-700 mt-1">{{ $medicine->description }}</p>
                </div>
            @endif
        </div>

        <div class="pt-4 border-t flex justify-between items-center text-xs">
            <a href="{{ route('medicines.index') }}" class="text-slate-500 hover:underline">&larr; Back to Pharmacy</a>
            <div class="space-x-2">
                <a href="{{ route('medicines.edit', $medicine) }}" class="px-3 py-1.5 border rounded text-slate-700 font-semibold">Edit</a>
                <a href="{{ route('medicines.delete', $medicine) }}" class="px-3 py-1.5 bg-rose-50 text-rose-700 rounded font-semibold">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection
