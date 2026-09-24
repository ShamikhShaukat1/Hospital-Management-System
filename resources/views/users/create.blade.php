@extends('layouts.app')

@section('title', 'Add System User')
@section('page_title', 'Create New User Account')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 pb-3 mb-6 border-b">
                User Account Details
            </h3>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-xs mb-6">
                    <div class="font-bold mb-1">Please address the following errors:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-3 py-2 bg-slate-50 border @error('name') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 bg-slate-50 border @error('email') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">System Role *</label>
                        <select name="role" required
                            class="w-full px-3 py-2 bg-slate-50 border @error('role') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">Select Role</option>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin
                            </option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                            <option value="nurse" {{ old('role') == 'nurse' ? 'selected' : '' }}>Nurse</option>
                            <option value="receptionist" {{ old('role') == 'receptionist' ? 'selected' : '' }}>Receptionist
                            </option>
                            <option value="pharmacist" {{ old('role') == 'pharmacist' ? 'selected' : '' }}>Pharmacist
                            </option>
                            <option value="accountant" {{ old('role') == 'accountant' ? 'selected' : '' }}>Accountant
                            </option>
                            <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Account Status *</label>
                        <select name="status" required
                            class="w-full px-3 py-2 bg-slate-50 border @error('status') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+1 (555) 000-0000"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Password *</label>
                        <input type="password" name="password" required
                            class="w-full px-3 py-2 bg-slate-50 border @error('password') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Confirm Password *</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('users.index') }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold transition">Create
                        User</button>
                </div>
            </form>
        </div>
    </div>
@endsection
