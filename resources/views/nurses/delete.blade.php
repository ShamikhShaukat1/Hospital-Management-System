@extends('layouts.app')

@section('title', 'Delete Nurse')
@section('page_title', 'Confirm Deletion')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm text-center space-y-4">
            <div
                class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto text-xl font-bold">
                !
            </div>

            <div>
                <h2 class="text-lg font-bold text-slate-900">Delete Nurse Record?</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Are you sure you want to delete <span class="font-semibold text-slate-800">{{ $nurse->name }}</span>
                    (ID: {{ $nurse->nurse_id }})? This action cannot be undone.
                </p>
            </div>

            <form action="{{ route('nurses.destroy', $nurse) }}" method="POST" class="flex gap-3 pt-4">
                @csrf
                @method('DELETE')

                <a href="{{ route('nurses.index') }}"
                    class="w-1/2 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="w-1/2 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition">
                    Yes, Delete
                </button>
            </form>
        </div>
    </div>
@endsection
