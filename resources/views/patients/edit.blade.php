@extends('layouts.app')

@section('title', 'Edit Patient - ' . $patient->name)
@section('page_title', 'Edit Patient Record')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <div class="mb-6 pb-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Edit Patient: {{ $patient->name }}</h3>
                    <p class="text-sm text-slate-500">Update medical and personal information for ID: <span
                            class="font-mono text-teal-700 font-semibold">{{ $patient->patient_id }}</span></p>
                </div>
                <a href="{{ route('patients.show', $patient) }}"
                    class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                    &larr; View File
                </a>
            </div>

            <form method="POST" action="{{ route('patients.update', $patient) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-teal-700 mb-3">1. Personal Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-xs font-semibold uppercase text-slate-600 mb-1">Full
                                Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $patient->name) }}"
                                required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="gender" class="block text-xs font-semibold uppercase text-slate-600 mb-1">Gender
                                *</label>
                            <select id="gender" name="gender" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                                <option value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'selected' : '' }}>
                                    Male</option>
                                <option value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'selected' : '' }}>
                                    Female</option>
                                <option value="Other" {{ old('gender', $patient->gender) == 'Other' ? 'selected' : '' }}>
                                    Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="date_of_birth"
                                class="block text-xs font-semibold uppercase text-slate-600 mb-1">Date of Birth *</label>
                            <input type="date" id="date_of_birth" name="date_of_birth"
                                value="{{ old('date_of_birth', $patient->date_of_birth->format('Y-m-d')) }}" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="blood_group" class="block text-xs font-semibold uppercase text-slate-600 mb-1">Blood
                                Group</label>
                            <select id="blood_group" name="blood_group"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                                <option value="">Unknown / Pending Lab</option>
                                @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                    <option value="{{ $bg }}"
                                        {{ old('blood_group', $patient->blood_group) == $bg ? 'selected' : '' }}>
                                        {{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-teal-700 mb-3">2. Contact & Address</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-xs font-semibold uppercase text-slate-600 mb-1">Phone
                                Number *</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}"
                                required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-semibold uppercase text-slate-600 mb-1">Email
                                Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $patient->email) }}"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label for="address"
                                class="block text-xs font-semibold uppercase text-slate-600 mb-1">Residential
                                Address</label>
                            <textarea id="address" name="address" rows="2"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">{{ old('address', $patient->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-teal-700 mb-3">3. Emergency Contact & Status
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="emergency_contact"
                                class="block text-xs font-semibold uppercase text-slate-600 mb-1">Emergency Contact
                                Name</label>
                            <input type="text" id="emergency_contact" name="emergency_contact"
                                value="{{ old('emergency_contact', $patient->emergency_contact) }}"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="emergency_phone"
                                class="block text-xs font-semibold uppercase text-slate-600 mb-1">Emergency Phone</label>
                            <input type="text" id="emergency_phone" name="emergency_phone"
                                value="{{ old('emergency_phone', $patient->emergency_phone) }}"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="status" class="block text-xs font-semibold uppercase text-slate-600 mb-1">Status
                                *</label>
                            <select id="status" name="status" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                                <option value="active" {{ old('status', $patient->status) == 'active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="inactive"
                                    {{ old('status', $patient->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">
                    <a href="{{ route('patients.show', $patient) }}"
                        class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-semibold">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-teal-700 hover:bg-teal-800 text-white text-sm font-semibold shadow-md shadow-teal-700/20">
                        Update Patient Record
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
