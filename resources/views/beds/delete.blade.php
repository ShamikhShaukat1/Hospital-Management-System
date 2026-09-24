@extends('layouts.app')

@section('title', 'Delete Bed')
@section('page_title', 'Delete Bed Confirmation')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-xl border border-rose-200 shadow-sm p-6">
            <div class="text-center mb-6">
                <div
                    class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-xl">
                    !
                </div>
                <h3 class="text-lg font-bold text-slate-800">Delete Bed</h3>
                <p class="text-xs text-slate-500 mt-1">Are you sure you want to remove <strong class="text-slate-700">Bed
                        {{ $bed->bed_number }}</strong>? This will detach it from its room.</p>
            </div>

            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 mb-6 text-xs text-slate-600 space-y-1">
                <div><strong>Room:</strong> Room {{ $bed->room->room_number ?? 'Unassigned' }}</div>
                <div><strong>Status:</strong> {{ $bed->status }}</div>
            </div>

            <form method="POST" action="{{ route('beds.destroy', $bed) }}" class="flex gap-2">
                @csrf
                @method('DELETE')

                <a href="{{ route('beds.index') }}"
                    class="w-1/2 text-center py-2 border rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                <button type="submit"
                    class="w-1/2 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold shadow-sm">Delete
                    Bed</button>
            </form>
        </div>
    </div>
@endsection
