@extends('layouts.app')

@section('title', 'Hospital Reports')
@section('page_title', 'Analytics, Reports & Audit Exports')

@section('content')
    <div class="space-y-6">
        <p class="text-sm text-slate-500">Generate, view, and export printable operational and financial hospital reports.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('reports.patients') }}"
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                <div
                    class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl mb-4 group-hover:bg-teal-700 group-hover:text-white transition">
                    <i class="fas fa-user-injured"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-base mb-1">Patient Demographics Report</h4>
                <p class="text-xs text-slate-500">Demographic breakdowns, gender distribution, and newly registered patients.
                </p>
            </a>

            <a href="{{ route('reports.billing') }}"
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-700 group-hover:text-white transition">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-base mb-1">Billing & Revenue Report</h4>
                <p class="text-xs text-slate-500">Invoices generated, outstanding receivables, discounts, and tax
                    liabilities.</p>
            </a>

            <a href="{{ route('reports.medicines') }}"
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-xl mb-4 group-hover:bg-purple-700 group-hover:text-white transition">
                    <i class="fas fa-pills"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-base mb-1">Pharmacy Stock & Expiry Report</h4>
                <p class="text-xs text-slate-500">Current pharmaceutical stock values, low inventory thresholds, and
                    expiring batches.</p>
            </a>

            <a href="{{ route('reports.doctors') }}"
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                <div
                    class="w-12 h-12 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center text-xl mb-4 group-hover:bg-sky-700 group-hover:text-white transition">
                    <i class="fas fa-user-md"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-base mb-1">Physician Activity Report</h4>
                <p class="text-xs text-slate-500">Departmental coverage, consultation volumes, and specialist utilization.
                </p>
            </a>

            <a href="{{ route('reports.appointments') }}"
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl mb-4 group-hover:bg-amber-700 group-hover:text-white transition">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-base mb-1">Appointments Schedule Report</h4>
                <p class="text-xs text-slate-500">Scheduled outpatient bookings, completed visits, cancellations, and
                    no-shows.</p>
            </a>

            <a href="{{ route('reports.admissions') }}"
                class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                <div
                    class="w-12 h-12 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center text-xl mb-4 group-hover:bg-rose-700 group-hover:text-white transition">
                    <i class="fas fa-procedures"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-base mb-1">Inpatient Admissions Report</h4>
                <p class="text-xs text-slate-500">Ward occupancy lengths, room utilization, and discharge timelines.</p>
            </a>
        </div>
    </div>
@endsection
