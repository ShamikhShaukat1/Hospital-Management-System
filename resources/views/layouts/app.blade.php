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
                    <div class="relative">
                        <span
                            class="inline-flex items-center justify-center p-2 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-100 cursor-pointer">
                            <i class="far fa-bell text-lg"></i>
                            <span
                                class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                        </span>
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

    @yield('scripts')
</body>

</html>
