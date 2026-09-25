@extends('layouts.app')

@section('title', 'Notifications')
@section('page_title', 'Notifications')

@section('content')

    <div class="max-w-5xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Notifications
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Stay updated with activity in the hospital system.
                </p>
            </div>

            @if (auth()->user()->unreadNotifications->count() > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf

                    <button type="submit"
                        class="px-4 py-2.5 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm">
                        <i class="fas fa-check-double mr-2"></i>
                        Mark All as Read
                    </button>
                </form>
            @endif
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

            @forelse ($notifications as $notification)

                @php
                    $data = $notification->data;
                    $isUnread = is_null($notification->read_at);

                    $type = $data['type'] ?? 'general';

                    if ($type === 'appointment_created') {
                        $icon = 'fa-calendar-plus';
                        $iconContainer = 'bg-emerald-100 text-emerald-700';
                    } elseif ($type === 'appointment_updated') {
                        $icon = 'fa-calendar-pen';
                        $iconContainer = 'bg-blue-100 text-blue-700';
                    } elseif ($type === 'appointment_deleted') {
                        $icon = 'fa-calendar-xmark';
                        $iconContainer = 'bg-rose-100 text-rose-700';
                    } else {
                        $icon = 'fa-bell';
                        $iconContainer = 'bg-slate-100 text-slate-700';
                    }
                @endphp

                <div
                    class="px-6 py-5 border-b border-slate-100 last:border-b-0
                    {{ $isUnread ? 'bg-teal-50/40' : 'bg-white' }}
                    hover:bg-slate-50 transition-colors">

                    <div class="flex items-start gap-4">

                        <div
                            class="w-11 h-11 rounded-xl {{ $iconContainer }}
                            flex items-center justify-center flex-shrink-0">
                            <i class="fas {{ $icon }}"></i>
                        </div>

                        <div class="flex-1 min-w-0">

                            <div class="flex items-start justify-between gap-4">

                                <div>
                                    <div class="flex items-center gap-2">

                                        <h3 class="font-semibold text-slate-800">
                                            {{ $data['title'] ?? 'Notification' }}
                                        </h3>

                                        @if ($isUnread)
                                            <span class="w-2 h-2 rounded-full bg-teal-600" title="Unread"></span>
                                        @endif

                                    </div>

                                    <p class="text-sm text-slate-600 mt-1">
                                        {{ $data['message'] ?? '' }}
                                    </p>
                                </div>

                                <span class="text-xs text-slate-400 whitespace-nowrap">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>

                            </div>

                            @if (!empty($data['patient_name']) || !empty($data['doctor_name']))
                                <div class="mt-3 flex flex-wrap gap-2">

                                    @if (!empty($data['patient_name']))
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs">
                                            <i class="fas fa-user-injured mr-1.5"></i>
                                            {{ $data['patient_name'] }}
                                        </span>
                                    @endif

                                    @if (!empty($data['doctor_name']))
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs">
                                            <i class="fas fa-user-md mr-1.5"></i>
                                            {{ $data['doctor_name'] }}
                                        </span>
                                    @endif

                                    @if (!empty($data['appointment_date']))
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs">
                                            <i class="fas fa-calendar mr-1.5"></i>
                                            {{ $data['appointment_date'] }}
                                        </span>
                                    @endif

                                    @if (!empty($data['appointment_time']))
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs">
                                            <i class="fas fa-clock mr-1.5"></i>
                                            {{ $data['appointment_time'] }}
                                        </span>
                                    @endif

                                </div>
                            @endif

                            <div class="flex items-center gap-2 mt-4">

                                @if (!empty($data['url']) && $type !== 'appointment_deleted')
                                    <a href="{{ $data['url'] }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-teal-700 hover:bg-teal-800 text-white text-xs font-semibold transition-colors">
                                        <i class="fas fa-eye mr-1.5"></i>
                                        View
                                    </a>
                                @endif

                                @if ($isUnread)
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                        @csrf

                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                                            <i class="fas fa-check mr-1.5"></i>
                                            Mark as Read
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold transition-colors">
                                        <i class="fas fa-trash mr-1.5"></i>
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="py-16 text-center">

                    <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                        <i class="far fa-bell-slash text-2xl"></i>
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-slate-700">
                        No notifications
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        You're all caught up.
                    </p>

                </div>

            @endforelse

        </div>

        @if ($notifications->hasPages())

            <div class="mt-6 flex items-center justify-between">

                {{-- Showing count --}}
                <div class="text-sm text-slate-500">
                    Showing
                    <span class="font-semibold text-slate-700">
                        {{ $notifications->firstItem() }}
                    </span>
                    to
                    <span class="font-semibold text-slate-700">
                        {{ $notifications->lastItem() }}
                    </span>
                    of
                    <span class="font-semibold text-slate-700">
                        {{ $notifications->total() }}
                    </span>
                    notifications
                </div>

                {{-- Pagination --}}
                <div class="flex items-center gap-2">

                    {{-- Previous --}}
                    @if ($notifications->onFirstPage())
                        <span
                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 text-xs font-semibold cursor-not-allowed">
                            <i class="fas fa-chevron-left mr-1.5"></i>
                            Previous
                        </span>
                    @else
                        <a href="{{ $notifications->previousPageUrl() }}"
                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-teal-700 hover:bg-teal-800 text-white text-xs font-semibold transition-colors">
                            <i class="fas fa-chevron-left mr-1.5"></i>
                            Previous
                        </a>
                    @endif


                    {{-- Page Numbers --}}
                    @foreach ($notifications->getUrlRange(1, $notifications->lastPage()) as $page => $url)
                        @if ($page == $notifications->currentPage())
                            <span
                                class="inline-flex items-center justify-center min-w-[32px] px-3 py-1.5 rounded-lg bg-teal-700 text-white text-xs font-semibold">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="inline-flex items-center justify-center min-w-[32px] px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-teal-700 hover:text-white text-slate-700 text-xs font-semibold transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach


                    {{-- Next --}}
                    @if ($notifications->hasMorePages())
                        <a href="{{ $notifications->nextPageUrl() }}"
                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-teal-700 hover:bg-teal-800 text-white text-xs font-semibold transition-colors">
                            Next
                            <i class="fas fa-chevron-right ml-1.5"></i>
                        </a>
                    @else
                        <span
                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 text-xs font-semibold cursor-not-allowed">
                            Next
                            <i class="fas fa-chevron-right ml-1.5"></i>
                        </span>
                    @endif

                </div>

            </div>

        @endif

    </div>

@endsection
