@extends('layouts.app')

@section('title', 'Delete Room')
@section('page_title', 'Delete Room Confirmation')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-xl border border-rose-200 shadow-sm p-6">
            <div class="text-center mb-6">
                <div
                    class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-xl">
                    !
                </div>
                <h3 class="text-lg font-bold text-slate-800">Confirm Deletion</h3>
                <p class="text-xs text-slate-500 mt-1">Are you sure you want to delete <strong class="text-slate-700">Room
                        {{ $room->room_number }}</strong>? This action cannot be undone.</p>
            </div>

            <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 mb-6 text-xs text-slate-600 space-y-1">
                <div><strong>Type:</strong> {{ $room->room_type }}</div>
                <div><strong>Floor:</strong> {{ $room->floor }}</div>
                <div><strong>Total Beds Attached:</strong> {{ $room->beds->count() }}</div>
            </div>

            <form method="POST" action="{{ route('rooms.destroy', $room) }}" class="flex gap-2">
                @csrf
                @method('DELETE')

                <a href="{{ route('rooms.index') }}"
                    class="w-1/2 text-center py-2 border rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                <button type="submit"
                    class="w-1/2 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold shadow-sm">Delete
                    Room</button>
            </form>
        </div>
    </div>
@endsection
