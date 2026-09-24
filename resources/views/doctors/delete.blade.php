@extends('layouts.app')

@section('title', 'Delete Doctor Confirmation')
@section('page_title', 'Delete Doctor Record')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <div class="bg-white rounded-2xl border border-rose-200 shadow-lg p-6 md:p-8 text-center">
        <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mx-auto mb-4 border border-rose-100">
            <i class="fas fa-user-times"></i>
        </div>

        <h3 class="text-xl font-bold text-slate-800">Confirm Doctor Removal</h3>
        <p class="text-sm text-slate-600 mt-2">
            Are you sure you want to delete this record for <strong class="text-slate-900 font-semibold">{{ $doctor->name }}</strong> (<span class="font-mono text-teal-700">{{ $doctor->doctor_id }}</span>)?
        </p>

        <div class="bg-slate-50 rounded-xl p-4 my-6 text-left text-xs text-slate-600 space-y-1.5 border border-slate-200">
            <div><strong class="text-slate-700">Specialization:</strong> {{ $doctor->specialization }} ({{ $doctor->department->name ?? 'General' }})</div>
            <div><strong class="text-slate-700">Phone & Email:</strong> {{ $doctor->phone }} &bull; {{ $doctor->email }}</div>
            <div><strong class="text-slate-700">Active Consultations:</strong> {{ $doctor->appointments()->count() }}</div>
        </div>

        <form method="POST" action="{{ route('doctors.destroy', $doctor) }}" class="flex items-center justify-center gap-3">
            @csrf
            @method('DELETE')
            <a href="{{ route('doctors.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 text-sm font-semibold transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold shadow-md shadow-rose-600/20 transition">
                Delete Permanently
            </button>
        </form>
    </div>
</div>
@endsection
