@extends('layouts.app')

@section('title', 'Add Department')
@section('page_title', 'Create Department')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 pb-3 border-b">New Department Information</h3>
        <form method="POST" action="{{ route('departments.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Department Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Cardiology, Pediatrics" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Status *</label>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="pt-4 border-t flex justify-end gap-2">
                <a href="{{ route('departments.index') }}" class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-600">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold">Save Department</button>
            </div>
        </form>
    </div>
</div>
@endsection
