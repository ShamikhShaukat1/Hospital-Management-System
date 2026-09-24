@extends('layouts.app')

@section('title', 'Pharmacy Inventory')
@section('page_title', 'Pharmacy & Medicine Inventory')

@section('content')
    <div class="space-y-6">
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('medicines.index') }}"
                class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search brand or generic name..."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">
                </div>

                <select name="category"
                    class="py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-700">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}</option>
                    @endforeach
                </select>

                <select name="filter"
                    class="py-2 px-3 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-700">
                    <option value="">All Stock</option>
                    <option value="low_stock" {{ request('filter') == 'low_stock' ? 'selected' : '' }}>Low Stock (&le; 20)
                    </option>
                </select>

                <button type="submit"
                    class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm flex items-center justify-center gap-2 transition">
                    Filter</button>
                @if (request()->hasAny(['search', 'category', 'filter']))
                    <a href="{{ route('medicines.index') }}" class="text-xs text-slate-500 underline">Reset</a>
                @endif
            </form>

            <a href="{{ route('medicines.create') }}"
                class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2">
                <i class="fas fa-plus"></i> Add New Medicine
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                        <tr>
                            <th class="p-3.5 px-6">Brand Name</th>
                            <th class="p-3.5 px-6">Generic Name</th>
                            <th class="p-3.5 px-6">Category</th>
                            <th class="p-3.5 px-6">Current Stock</th>
                            <th class="p-3.5 px-6">Unit Price</th>
                            <th class="p-3.5 px-6">Expiry Date</th>
                            <th class="p-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($medicines as $med)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3.5 px-6 font-bold text-slate-900 text-sm">{{ $med->name }}</td>
                                <td class="p-3.5 px-6 text-slate-500">{{ $med->generic_name }}</td>
                                <td class="p-3.5 px-6">
                                    <span
                                        class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold">{{ $med->category }}</span>
                                </td>
                                <td class="p-3.5 px-6">
                                    @if ($med->stock_quantity <= 20)
                                        <span class="px-2 py-0.5 rounded-full font-bold bg-rose-100 text-rose-700">
                                            {{ $med->stock_quantity }} (Low)
                                        </span>
                                    @else
                                        <span class="font-bold text-slate-800">{{ $med->stock_quantity }}</span>
                                    @endif
                                </td>
                                <td class="p-3.5 px-6 font-semibold text-emerald-700">${{ number_format($med->price, 2) }}
                                </td>
                                <td
                                    class="p-3.5 px-6 {{ $med->expiry_date->isPast() ? 'text-rose-600 font-bold' : 'text-slate-500' }}">
                                    {{ $med->expiry_date->format('M d, Y') }}
                                </td>
                                <td class="p-3.5 px-6 text-right space-x-1">
                                    <a href="{{ route('medicines.show', $med) }}"
                                        class="p-1.5 text-slate-400 hover:text-teal-700" title="View">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ route('medicines.edit', $med) }}"
                                        class="p-1.5 text-slate-400 hover:text-indigo-600" title="Edit">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="{{ route('medicines.delete', $med) }}"
                                        class="p-1.5 text-slate-400 hover:text-rose-600" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-400">No pharmacy inventory items found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($medicines->hasPages())
                <div class="p-4 border-t">
                    {{ $medicines->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
