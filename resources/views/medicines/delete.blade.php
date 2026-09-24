@extends('layouts.app')

@section('title', 'Delete Medicine')
@section('page_title', 'Delete Medicine Confirmation')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <div class="bg-white rounded-2xl border border-rose-200 shadow-lg p-6 md:p-8 text-center">
        <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mx-auto mb-4 border border-rose-100">
            <i class="fas fa-trash-alt"></i>
        </div>

        <h3 class="text-xl font-bold text-slate-800">Confirm Medicine Deletion</h3>
        <p class="text-sm text-slate-600 mt-2">
            Are you sure you want to delete <strong class="text-slate-900 font-semibold">{{ $medicine->name }}</strong> ({{ $medicine->generic_name }}) from inventory?
        </p>

        <form method="POST" action="{{ route('medicines.destroy', $medicine) }}" class="flex items-center justify-center gap-3 mt-6">
            @csrf
            @method('DELETE')
            <a href="{{ route('medicines.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-sm font-semibold transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold shadow-md shadow-rose-600/20 transition">
                Delete Permanently
            </button>
        </form>
    </div>
</div>
@endsection
