@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page_title', 'Hospital Executive Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Patients</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($stats['total_patients']) }}</h3>
                    <span class="inline-flex items-center text-xs font-medium text-emerald-600 mt-1">
                        <i class="fas fa-arrow-up mr-1 text-[10px]"></i> Active Records
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl">
                    <i class="fas fa-user-injured"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Doctors</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($stats['total_doctors']) }}</h3>
                    <span class="inline-flex items-center text-xs font-medium text-teal-600 mt-1">
                        <i class="fas fa-check-circle mr-1 text-[10px]"></i> Specialists on Duty
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Today's Appointments</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($stats['today_appointments']) }}
                    </h3>
                    <span class="inline-flex items-center text-xs font-medium text-amber-600 mt-1">
                        <i class="fas fa-clock mr-1 text-[10px]"></i> {{ $stats['pending_appointments'] }} Pending
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Bed Availability</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['available_beds'] }} <span
                            class="text-sm font-normal text-slate-500">/ {{ $stats['total_beds'] }} Free</span></h3>
                    <span class="inline-flex items-center text-xs font-medium text-teal-600 mt-1">
                        <i class="fas fa-procedures mr-1 text-[10px]"></i> {{ $stats['current_admissions'] }} Admitted
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fas fa-bed"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-purple-50 text-purple-600 rounded-lg text-lg">
                    <i class="fas fa-user-nurse"></i>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase font-semibold">Nurses & Staff</div>
                    <div class="text-lg font-bold text-slate-800">{{ $stats['total_nurses'] }} Nurses &bull;
                        {{ $stats['total_staff'] }} Staff</div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-teal-50 text-teal-600 rounded-lg text-lg">
                    <i class="fas fa-pills"></i>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase font-semibold">Total Medicines</div>
                    <div class="text-lg font-bold text-slate-800">{{ $stats['total_medicines'] }} Items</div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-lg text-lg">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase font-semibold">Low Stock Warnings</div>
                    <div class="text-lg font-bold text-rose-600">{{ $stats['low_stock_medicines'] }} Medicines Low</div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center space-x-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg text-lg">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase font-semibold">Today's Revenue</div>
                    <div class="text-lg font-bold text-emerald-700">${{ number_format($stats['today_payments'], 2) }}</div>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-r from-teal-800 to-teal-900 rounded-2xl p-6 text-white shadow-md flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold">CarePoint Fast Actions</h3>
                <p class="text-teal-200 text-sm mt-0.5">Quickly register patients, schedule consultations, admit emergencies
                    or dispense prescriptions.</p>
            </div>
            <div class="flex flex-wrap gap-2.5">
                <a href="{{ route('patients.create') }}"
                    class="px-4 py-2 bg-teal-600 hover:bg-teal-500 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                    <i class="fas fa-user-plus mr-1.5"></i> Register Patient
                </a>
                <a href="{{ route('appointments.create') }}"
                    class="px-4 py-2 bg-white text-teal-900 hover:bg-slate-100 rounded-lg text-sm font-semibold shadow-sm transition">
                    <i class="fas fa-calendar-plus mr-1.5"></i> Book Appointment
                </a>
                <a href="{{ route('admissions.create') }}"
                    class="px-4 py-2 bg-teal-700 hover:bg-teal-600 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                    <i class="fas fa-bed mr-1.5"></i> Admit Patient
                </a>
                <a href="{{ route('billing.create') }}"
                    class="px-4 py-2 bg-teal-700 hover:bg-teal-600 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                    <i class="fas fa-file-invoice-dollar mr-1.5"></i> Create Bill
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 px-6 border-b border-slate-100 flex items-center justify-between">
                    <h4 class="font-bold text-slate-800 flex items-center">
                        <i class="far fa-calendar-alt text-teal-700 mr-2"></i> Today's Scheduled Consultations
                    </h4>
                    <a href="{{ route('appointments.index') }}"
                        class="text-xs text-teal-700 font-semibold hover:underline">View All &rarr;</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($todayAppointments as $app)
                        <div class="p-4 px-6 flex items-center justify-between hover:bg-slate-50 transition">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-xs">
                                    {{ date('g:i A', strtotime($app->appointment_time)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800 text-sm">
                                        {{ $app->patient->name ?? 'Patient' }}</div>
                                    <div class="text-xs text-slate-500">Dr. {{ $app->doctor->name ?? 'Doctor' }} &bull;
                                        {{ $app->department->name ?? 'General' }}</div>
                                </div>
                            </div>
                            <div>
                                @if ($app->status === 'Confirmed')
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Confirmed</span>
                                @elseif($app->status === 'Pending')
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Pending</span>
                                @elseif($app->status === 'Completed')
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full bg-teal-100 text-teal-800">Completed</span>
                                @else
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-800">Cancelled</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400 text-sm">
                            No appointments scheduled for today.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 px-6 border-b border-slate-100 flex items-center justify-between">
                    <h4 class="font-bold text-slate-800 flex items-center">
                        <i class="fas fa-procedures text-teal-700 mr-2"></i> Recent Inpatient Admissions
                    </h4>
                    <a href="{{ route('admissions.index') }}"
                        class="text-xs text-teal-700 font-semibold hover:underline">View All &rarr;</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($recentAdmissions as $adm)
                        <div class="p-4 px-6 flex items-center justify-between hover:bg-slate-50 transition">
                            <div>
                                <div class="font-semibold text-slate-800 text-sm">{{ $adm->patient->name ?? 'Patient' }}
                                </div>
                                <div class="text-xs text-slate-500">Room {{ $adm->room->room_number ?? '-' }} &bull; Bed
                                    {{ $adm->bed->bed_number ?? '-' }} &bull; Dr. {{ $adm->doctor->name ?? '-' }}</div>
                            </div>
                            <div class="text-right">
                                <span
                                    class="text-xs font-medium text-slate-500 block">{{ $adm->admission_date->format('M d, Y') }}</span>
                                <a href="{{ route('discharges.create', ['admission_id' => $adm->id]) }}"
                                    class="text-xs font-semibold text-teal-700 hover:text-teal-900">
                                    Prepare Discharge &rarr;
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400 text-sm">
                            No current inpatients in the ward.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 px-6 border-b border-slate-100 flex items-center justify-between">
                    <h4 class="font-bold text-slate-800 flex items-center text-rose-700">
                        <i class="fas fa-triangle-exclamation mr-2"></i> Pharmacy Inventory Alerts (Low Stock)
                    </h4>
                    <a href="{{ route('medicines.index', ['filter' => 'low_stock']) }}"
                        class="text-xs text-rose-700 font-semibold hover:underline">Manage Stock &rarr;</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($lowStockList as $med)
                        <div class="p-4 px-6 flex items-center justify-between hover:bg-slate-50">
                            <div>
                                <div class="font-semibold text-slate-800 text-sm">{{ $med->name }}</div>
                                <div class="text-xs text-slate-500">{{ $med->generic_name }} &bull; {{ $med->category }}
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-rose-100 text-rose-800">
                                    Only {{ $med->stock_quantity }} in stock
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-emerald-600 text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i> All pharmacy inventory items are adequately stocked.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 px-6 border-b border-slate-100 flex items-center justify-between">
                    <h4 class="font-bold text-slate-800 flex items-center">
                        <i class="fas fa-file-invoice-dollar text-teal-700 mr-2"></i> Recent Hospital Invoices
                    </h4>
                    <a href="{{ route('billing.index') }}"
                        class="text-xs text-teal-700 font-semibold hover:underline">View All &rarr;</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($recentInvoices as $inv)
                        <div class="p-4 px-6 flex items-center justify-between hover:bg-slate-50">
                            <div>
                                <div class="font-semibold text-slate-800 text-sm">{{ $inv->invoice_number }} &bull;
                                    {{ $inv->patient->name ?? 'Patient' }}</div>
                                <div class="text-xs text-slate-500">{{ $inv->invoice_date->format('M d, Y') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-slate-800 text-sm">${{ number_format($inv->total, 2) }}</div>
                                <span
                                    class="text-[11px] font-semibold uppercase {{ $inv->status === 'Paid' ? 'text-emerald-600' : ($inv->status === 'Partial' ? 'text-amber-600' : 'text-rose-600') }}">
                                    {{ $inv->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400 text-sm">
                            No recent invoices found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection
