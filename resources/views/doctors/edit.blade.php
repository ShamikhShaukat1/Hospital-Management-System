@extends('layouts.app')

@section('title', 'Edit Doctor')
@section('page_title', 'Edit Doctor Profile')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <div class="mb-6 pb-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Edit Doctor Profile</h3>
                    <p class="text-xs text-slate-500 font-medium">Doctor ID: {{ $doctor->doctor_id }}</p>
                </div>
                <a href="{{ route('doctors.show', $doctor) }}"
                    class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                    &larr; Back to Doctor Profile
                </a>
            </div>

            <form method="POST" action="{{ route('doctors.update', $doctor) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Doctor Name *</label>
                        <input type="text" name="name" value="{{ old('name', $doctor->name) }}"
                            placeholder="Dr. John Smith" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Department *</label>
                        <select name="department_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">Select Department</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ old('department_id', $doctor->department_id) == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Specialization *</label>
                        <input type="text" name="specialization"
                            value="{{ old('specialization', $doctor->specialization) }}"
                            placeholder="e.g. Cardiologist, Neurologist" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Qualification *</label>
                        <input type="text" name="qualification"
                            value="{{ old('qualification', $doctor->qualification) }}" placeholder="e.g. MBBS, MD, FRCS"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email', $doctor->email) }}" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Phone Number *</label>
                        <input type="text" name="phone" value="{{ old('phone', $doctor->phone) }}" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Consultation Fee ($)
                            *</label>
                        <input type="number" step="0.01" name="consultation_fee"
                            value="{{ old('consultation_fee', $doctor->consultation_fee) }}" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Status *</label>
                        <select name="status" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="active" {{ old('status', $doctor->status) == 'active' ? 'selected' : '' }}>
                                Active Duty</option>
                            <option value="inactive" {{ old('status', $doctor->status) == 'inactive' ? 'selected' : '' }}>
                                On Leave / Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Office / Clinic
                            Address</label>
                        <textarea name="address" rows="2"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">{{ old('address', $doctor->address) }}</textarea>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">
                    <a href="{{ route('doctors.show', $doctor) }}"
                        class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm font-semibold">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-teal-700 hover:bg-teal-800 text-white text-sm font-semibold shadow-md shadow-teal-700/20">
                        Update Doctor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
