@extends('layouts.app')

@section('title', 'User Administration')
@section('page_title', 'Users, Credentials & Role Permissions')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center justify-between">
                <div>{{ session('success') }}</div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
            </div>
        @endif

        @if ($errors->has('error'))
            <div
                class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center justify-between">
                <div>{{ $errors->first('error') }}</div>
                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-900">&times;</button>
            </div>
        @endif

        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <form method="GET" action="{{ route('users.index') }}"
                class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search user name, email, phone..."
                    class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-teal-600">

                <select name="role"
                    class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">
                    <option value="">All Roles</option>
                    <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin
                    </option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="doctor" {{ request('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                    <option value="nurse" {{ request('role') == 'nurse' ? 'selected' : '' }}>Nurse</option>
                    <option value="receptionist" {{ request('role') == 'receptionist' ? 'selected' : '' }}>Receptionist
                    </option>
                    <option value="pharmacist" {{ request('role') == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                    <option value="accountant" {{ request('role') == 'accountant' ? 'selected' : '' }}>Accountant</option>
                    <option value="patient" {{ request('role') == 'patient' ? 'selected' : '' }}>Patient</option>
                </select>

                <select name="status"
                    class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-600">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                    Filter
                </button>

                @if (request('search') || request('role') || request('status'))
                    <a href="{{ route('users.index') }}"
                        class="text-xs text-slate-500 hover:text-slate-700 font-semibold underline">
                        Clear filters
                    </a>
                @endif
            </form>

            <a href="{{ route('users.create') }}"
                class="w-full md:w-auto px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2 transition">
                <i class="fas fa-user-plus"></i> Add System User
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold">
                    <tr>
                        <th class="p-3.5 px-6">Name</th>
                        <th class="p-3.5 px-6">Email Address</th>
                        <th class="p-3.5 px-6">System Role</th>
                        <th class="p-3.5 px-6">Phone</th>
                        <th class="p-3.5 px-6">Status</th>
                        <th class="p-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3.5 px-6 font-bold text-slate-900">
                                <a href="{{ route('users.show', $user) }}" class="hover:text-teal-700">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class="p-3.5 px-6">{{ $user->email }}</td>
                            <td class="p-3.5 px-6">
                                <span
                                    class="px-2.5 py-1 rounded-md font-semibold text-[11px] uppercase tracking-wider bg-teal-50 text-teal-800 border border-teal-200">
                                    {{ str_replace('_', ' ', $user->role) }}
                                </span>
                            </td>
                            <td class="p-3.5 px-6 text-slate-500">{{ $user->phone ?? 'N/A' }}</td>
                            <td class="p-3.5 px-6">
                                <span
                                    class="px-2 py-0.5 rounded font-semibold {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="p-3.5 px-6 text-right space-x-2">
                                <a href="{{ route('users.show', $user) }}" class="p-1.5 text-slate-400 hover:text-teal-600"
                                    title="View Details">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user) }}"
                                    class="p-1.5 text-slate-400 hover:text-indigo-600" title="Edit User">
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">No user accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($users->hasPages())
                <div class="p-4 border-t">{{ $users->links() }}</div>
            @endif
        </div>
    </div>
@endsection
