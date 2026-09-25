<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Hospital Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F766E',
                        'primary-dark': '#0D635D',
                        secondary: '#14B8A6',
                        accent: '#F0FDFA',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }

            body {
                background-color: white !important;
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased h-screen flex overflow-hidden">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
        <header class="bg-white border-b border-slate-200 sticky top-0 z-20 flex-shrink-0">
            <div class="px-6 py-3.5 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <button id="sidebarToggle" class="text-slate-500 hover:text-slate-700 md:hidden focus:outline-none">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-xl font-bold text-slate-800 tracking-tight">@yield('page_title', 'Hospital Management System')</h1>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative" id="notificationContainer">
                        <button type="button" id="notificationButton"
                            class="relative inline-flex items-center justify-center p-2 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-100 cursor-pointer transition-colors focus:outline-none">

                            <i class="far fa-bell text-lg"></i>

                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <span
                                    class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center ring-2 ring-white">
                                    {{ auth()->user()->unreadNotifications->count() > 99 ? '99+' : auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>

                        <div id="notificationDropdown"
                            class="hidden absolute right-0 mt-3 w-96 bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden z-50">
                            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-slate-800">
                                        Notifications
                                    </h3>

                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ auth()->user()->unreadNotifications->count() }} unread
                                    </p>
                                </div>
                            </div>

                            <div class="max-h-[400px] overflow-y-auto">
                                @forelse (auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                                    @php
                                        $data = $notification->data;
                                        $isUnread = is_null($notification->read_at);
                                        $type = $data['type'] ?? 'general';

                                        if ($type === 'appointment_created') {
                                            $icon = 'fa-calendar-plus';
                                            $iconClass = 'text-emerald-600 bg-emerald-50';
                                        } elseif ($type === 'appointment_updated') {
                                            $icon = 'fa-calendar-pen';
                                            $iconClass = 'text-blue-600 bg-blue-50';
                                        } elseif ($type === 'appointment_deleted') {
                                            $icon = 'fa-calendar-xmark';
                                            $iconClass = 'text-rose-600 bg-rose-50';
                                        } else {
                                            $icon = 'fa-bell';
                                            $iconClass = 'text-slate-600 bg-slate-100';
                                        }
                                    @endphp

                                    <div
                                        class="px-5 py-4 border-b border-slate-100 last:border-b-0 {{ $isUnread ? 'bg-teal-50/50' : 'bg-white' }} hover:bg-slate-50 transition-colors">
                                        <div class="flex gap-3">
                                            <div
                                                class="w-9 h-9 rounded-lg {{ $iconClass }} flex items-center justify-center flex-shrink-0">
                                                <i class="fas {{ $icon }} text-sm"></i>
                                            </div>

                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between gap-2">
                                                    <h4 class="text-sm font-semibold text-slate-800 truncate">
                                                        {{ $data['title'] ?? 'Notification' }}
                                                    </h4>

                                                    @if ($isUnread)
                                                        <span
                                                            class="w-2 h-2 bg-teal-600 rounded-full flex-shrink-0 mt-1.5"></span>
                                                    @endif

                                                </div>

                                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                                    {{ $data['message'] ?? '' }}
                                                </p>

                                                <div class="flex items-center justify-between mt-2">
                                                    <span class="text-[11px] text-slate-400">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </span>

                                                    @if (!empty($data['url']) && $type !== 'appointment_deleted')
                                                        <a href="{{ $data['url'] }}"
                                                            class="text-[11px] font-semibold text-teal-700 hover:text-teal-800">
                                                            View
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <div class="py-10 text-center">
                                        <i class="far fa-bell-slash text-2xl text-slate-300"></i>

                                        <p class="text-sm text-slate-500 mt-3">
                                            No notifications yet.
                                        </p>
                                    </div>
                                @endforelse
                            </div>

                            <div class="px-5 py-3 bg-slate-50 border-t border-slate-200">
                                <a href="{{ route('notifications.index') }}"
                                    class="block text-center text-sm font-semibold text-teal-700 hover:text-teal-800">
                                    View all notifications
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center pl-3 border-l border-slate-200 space-x-3">
                        <div
                            class="w-8 h-8 rounded-full bg-teal-700 text-white flex items-center justify-center font-semibold text-sm shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-sm font-semibold text-slate-800 leading-none">
                                {{ Auth::user()->name ?? 'Administrator' }}</div>
                            <div class="text-xs text-teal-600 font-medium uppercase mt-0.5 tracking-wider">
                                {{ str_replace('_', ' ', Auth::user()->role ?? 'Admin') }}</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" title="Logout"
                                class="p-2 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                                <i class="fas fa-arrow-right-from-bracket"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-8">
            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm animate-fade-in">
                    <i class="fas fa-circle-check text-emerald-600 text-lg mt-0.5"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-emerald-900">Success</h4>
                        <p class="text-sm mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 shadow-sm">
                    <i class="fas fa-triangle-exclamation text-rose-600 text-lg mt-0.5"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-rose-900">Please review the errors below:</h4>
                        <ul class="list-disc pl-5 text-sm mt-1 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const notificationButton = document.getElementById('notificationButton');
            const notificationDropdown = document.getElementById('notificationDropdown');
            const notificationContainer = document.getElementById('notificationContainer');

            if (notificationButton && notificationDropdown) {

                notificationButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    notificationDropdown.classList.toggle('hidden');

                });

                document.addEventListener('click', function(event) {
                    if (notificationContainer && !notificationContainer.contains(event.target)) {
                        notificationDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    @yield('scripts')

    @yield('scripts')
</body>

</html>
