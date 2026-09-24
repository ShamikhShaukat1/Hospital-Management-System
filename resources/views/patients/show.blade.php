@extends('layouts.app')

@section('title', $patient->name . ' - Medical File')
@section('page_title', 'Patient Complete Medical File')

@section('content')
    <div class="space-y-6">

        <div
            class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div
                    class="w-16 h-16 rounded-2xl bg-teal-700 text-white flex items-center justify-center text-2xl font-bold shadow-md shadow-teal-700/20">
                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-bold text-slate-800">{{ $patient->name }}</h2>
                        <span
                            class="px-2.5 py-0.5 text-xs font-mono font-bold rounded-md bg-teal-50 text-teal-700 border border-teal-200">
                            {{ $patient->patient_id }}
                        </span>
                        @if ($patient->blood_group)
                            <span class="px-2 py-0.5 text-xs font-bold rounded bg-rose-100 text-rose-800">
                                {{ $patient->blood_group }}
                            </span>
                        @endif
                    </div>
                    <div class="text-xs text-slate-500 mt-1 flex flex-wrap gap-x-4 gap-y-1">
                        <span><i class="far fa-calendar mr-1"></i> DOB: {{ $patient->date_of_birth->format('M d, Y') }}
                            ({{ $patient->date_of_birth->age }} yrs)</span>
                        <span><i class="fas fa-venus-mars mr-1"></i> {{ $patient->gender }}</span>
                        <span><i class="fas fa-phone mr-1"></i> {{ $patient->phone }}</span>
                        <span><i class="far fa-envelope mr-1"></i> {{ $patient->email ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}"
                    class="px-3.5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                    <i class="fas fa-calendar-plus mr-1"></i> Book Visit
                </a>
                <a href="{{ route('medical-records.create', ['patient_id' => $patient->id]) }}"
                    class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                    <i class="fas fa-notes-medical mr-1"></i> Add Record
                </a>
                <a href="{{ route('patients.edit', $patient) }}"
                    class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition">
                    <i class="far fa-edit mr-1"></i> Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b pb-2">Emergency Contact</h4>
                <div>
                    <div class="text-xs text-slate-500">Contact Person</div>
                    <div class="text-sm font-semibold text-slate-800">{{ $patient->emergency_contact ?? 'Not Specified' }}
                    </div>
                </div>
                <div>
                    <div class="text-xs text-slate-500">Emergency Phone</div>
                    <div class="text-sm font-semibold text-slate-800">{{ $patient->emergency_phone ?? 'Not Specified' }}
                    </div>
                </div>
                <div>
                    <div class="text-xs text-slate-500">Address</div>
                    <div class="text-sm text-slate-700">{{ $patient->address ?? 'No address registered' }}</div>
                </div>
            </div>

            <div class="md:col-span-2 bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between border-b pb-2 mb-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">Appointments History</h4>
                    <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}"
                        class="text-xs text-teal-700 font-semibold hover:underline">+ New Visit</a>
                </div>
                <div class="space-y-2">
                    @forelse($patient->appointments->take(4) as $app)
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50 text-xs">
                            <div>
                                <span class="font-bold text-slate-800">{{ $app->appointment_date->format('M d, Y') }} at
                                    {{ date('g:i A', strtotime($app->appointment_time)) }}</span>
                                <span class="text-slate-500 ml-2">with Dr. {{ $app->doctor->name ?? '-' }}</span>
                                <p class="text-slate-600 mt-0.5">{{ $app->reason }}</p>
                            </div>
                            <span
                                class="px-2 py-0.5 rounded font-semibold {{ $app->status === 'Completed' ? 'bg-teal-100 text-teal-800' : ($app->status === 'Confirmed' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700') }}">
                                {{ $app->status }}
                            </span>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 py-3 text-center">No appointments on file.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-center justify-between border-b pb-2 mb-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">Medical Diagnoses & Records</h4>
                    <a href="{{ route('medical-records.create', ['patient_id' => $patient->id]) }}"
                        class="text-xs text-teal-700 font-semibold hover:underline">+ Add Record</a>
                </div>
                <div class="space-y-3">
                    @forelse($patient->medicalRecords as $record)
                        <div class="p-3.5 rounded-lg border border-slate-100 bg-slate-50">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                <span
                                    class="font-semibold text-slate-700">{{ $record->record_date->format('M d, Y') }}</span>
                                <span>Dr. {{ $record->doctor->name ?? '-' }}</span>
                            </div>
                            <h5 class="text-sm font-bold text-slate-800">{{ $record->diagnosis }}</h5>
                            @if ($record->symptoms)
                                <p class="text-xs text-slate-600 mt-1"><strong class="text-slate-700">Symptoms:</strong>
                                    {{ $record->symptoms }}</p>
                            @endif
                            @if ($record->treatment)
                                <p class="text-xs text-teal-700 mt-1"><strong class="text-slate-700">Treatment
                                        Plan:</strong> {{ $record->treatment }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 py-4 text-center">No clinical records logged yet.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-center justify-between border-b pb-2 mb-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">Issued Prescriptions</h4>
                    <a href="{{ route('prescriptions.create', ['patient_id' => $patient->id]) }}"
                        class="text-xs text-teal-700 font-semibold hover:underline">+ Prescribe</a>
                </div>
                <div class="space-y-3">
                    @forelse($patient->prescriptions as $rx)
                        <div class="p-3.5 rounded-lg border border-slate-100 bg-slate-50">
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="font-mono font-bold text-teal-700">{{ $rx->prescription_id }}</span>
                                <span class="text-slate-500">{{ $rx->prescription_date->format('M d, Y') }}</span>
                            </div>
                            <div class="text-xs text-slate-500 mb-2">Prescribed by Dr. {{ $rx->doctor->name ?? '-' }}</div>
                            <ul class="text-xs space-y-1">
                                @foreach ($rx->items as $item)
                                    <li class="flex items-center justify-between text-slate-700 font-medium">
                                        <span>&bull; {{ $item->medicine->name ?? 'Medicine' }}
                                            ({{ $item->dosage }})</span>
                                        <span class="text-slate-500 text-[11px]">{{ $item->frequency }} &bull;
                                            {{ $item->duration }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 py-4 text-center">No prescriptions on record.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b pb-2 mb-3">Inpatient
                    Admissions</h4>
                <div class="space-y-2">
                    @forelse($patient->admissions as $adm)
                        <div class="p-3 rounded-lg bg-slate-50 text-xs flex items-center justify-between">
                            <div>
                                <span class="font-bold text-slate-800">{{ $adm->admission_id }}</span>
                                <span class="text-slate-500 ml-1">Room {{ $adm->room->room_number ?? '-' }}, Bed
                                    {{ $adm->bed->bed_number ?? '-' }}</span>
                                <div class="text-slate-600 mt-0.5">{{ $adm->diagnosis }}
                                    ({{ $adm->admission_date->format('M d, Y') }})</div>
                            </div>
                            <span
                                class="px-2 py-0.5 rounded font-semibold {{ $adm->status === 'Admitted' ? 'bg-amber-100 text-amber-800' : 'bg-slate-200 text-slate-700' }}">
                                {{ $adm->status }}
                            </span>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 py-3 text-center">No inpatient admissions.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-center justify-between border-b pb-2 mb-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">Invoices & Payments</h4>
                    <a href="{{ route('billing.create', ['patient_id' => $patient->id]) }}"
                        class="text-xs text-teal-700 font-semibold hover:underline">+ New Bill</a>
                </div>
                <div class="space-y-2">
                    @forelse($patient->invoices as $inv)
                        <div class="p-3 rounded-lg bg-slate-50 text-xs flex items-center justify-between">
                            <div>
                                <span class="font-bold text-slate-800">{{ $inv->invoice_number }}</span>
                                <span class="text-slate-500 ml-1">{{ $inv->invoice_date->format('M d, Y') }}</span>
                                <div class="font-semibold text-slate-900 mt-0.5">${{ number_format($inv->total, 2) }}</div>
                            </div>
                            <span
                                class="px-2 py-0.5 rounded font-semibold {{ $inv->status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ $inv->status }}
                            </span>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 py-3 text-center">No billing history found.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection
