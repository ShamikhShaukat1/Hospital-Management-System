<aside
    class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col h-screen border-r border-slate-800 transition-all select-none">
    <div class="h-16 flex items-center px-6 bg-slate-950 border-b border-slate-800 gap-3 flex-shrink-0">
        <div
            class="w-9 h-9 rounded-xl bg-teal-600 flex items-center justify-center text-white font-bold text-lg shadow-md shadow-teal-900/50">
            <i class="fas fa-hospital-symbol"></i>
        </div>
        <div>
            <div class="font-bold text-white tracking-wide text-base leading-tight">CarePoint</div>
            <div class="text-[10px] uppercase font-semibold text-teal-400 tracking-widest">Hospital System</div>
        </div>
    </div>

    <nav id="sidebarNav"
        class="flex-1 px-3 py-4 space-y-6 overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-slate-700 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-slate-600">
        <div>
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i
                    class="fas fa-chart-pie w-6 text-center text-base {{ request()->routeIs('dashboard') ? 'text-teal-200' : 'text-slate-400' }}"></i>
                <span class="ml-2">Dashboard</span>
            </a>
        </div>

        @php $role = Auth::user()->role ?? 'admin'; @endphp

        @if (in_array($role, ['super_admin', 'admin', 'doctor', 'nurse', 'receptionist']))
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Hospital Management
                </div>
                <div class="space-y-1">
                    <a href="{{ route('patients.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('patients.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-user-injured w-6 text-center"></i>
                        <span class="ml-2">Patients</span>
                    </a>

                    @if (in_array($role, ['super_admin', 'admin', 'receptionist']))
                        <a href="{{ route('doctors.index') }}"
                            class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('doctors.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-user-md w-6 text-center"></i>
                            <span class="ml-2">Doctors</span>
                        </a>
                    @endif

                    @if (in_array($role, ['super_admin', 'admin']))
                        <a href="{{ route('departments.index') }}"
                            class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('departments.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-building w-6 text-center"></i>
                            <span class="ml-2">Departments</span>
                        </a>

                        <a href="{{ route('nurses.index') }}"
                            class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('nurses.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-user-nurse w-6 text-center"></i>
                            <span class="ml-2">Nurses</span>
                        </a>

                        <a href="{{ route('staff.index') }}"
                            class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('staff.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-users-cog w-6 text-center"></i>
                            <span class="ml-2">Staff</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <div>
            <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Appointments</div>
            <div class="space-y-1">
                <a href="{{ route('appointments.index') }}"
                    class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('appointments.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fas fa-calendar-check w-6 text-center"></i>
                    <span class="ml-2">Appointments</span>
                </a>
            </div>
        </div>

        @if (in_array($role, ['super_admin', 'admin', 'doctor', 'nurse', 'pharmacist', 'patient']))
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Medical</div>
                <div class="space-y-1">
                    @if (in_array($role, ['super_admin', 'admin', 'doctor', 'nurse', 'patient']))
                        <a href="{{ route('medical-records.index') }}"
                            class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('medical-records.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-notes-medical w-6 text-center"></i>
                            <span class="ml-2">Medical Records</span>
                        </a>
                    @endif

                    <a href="{{ route('prescriptions.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('prescriptions.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-prescription-bottle-alt w-6 text-center"></i>
                        <span class="ml-2">Prescriptions</span>
                    </a>
                </div>
            </div>
        @endif

        @if (in_array($role, ['super_admin', 'admin', 'pharmacist']))
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Pharmacy</div>
                <div class="space-y-1">
                    <a href="{{ route('medicines.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('medicines.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-pills w-6 text-center"></i>
                        <span class="ml-2">Medicines</span>
                    </a>
                </div>
            </div>
        @endif

        @if (in_array($role, ['super_admin', 'admin', 'doctor', 'nurse', 'receptionist']))
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Hospital Facilities
                </div>
                <div class="space-y-1">
                    <a href="{{ route('rooms.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('rooms.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-door-open w-6 text-center"></i>
                        <span class="ml-2">Rooms</span>
                    </a>

                    <a href="{{ route('beds.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('beds.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-bed w-6 text-center"></i>
                        <span class="ml-2">Beds</span>
                    </a>

                    <a href="{{ route('admissions.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admissions.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-procedures w-6 text-center"></i>
                        <span class="ml-2">Admissions</span>
                    </a>

                    <a href="{{ route('discharges.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('discharges.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-sign-out-alt w-6 text-center"></i>
                        <span class="ml-2">Discharges</span>
                    </a>
                </div>
            </div>
        @endif

        @if (in_array($role, ['super_admin', 'admin', 'accountant', 'patient']))
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Finance</div>
                <div class="space-y-1">
                    <a href="{{ route('billing.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('billing.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-file-invoice-dollar w-6 text-center"></i>
                        <span class="ml-2">Billing & Invoices</span>
                    </a>

                    @if (in_array($role, ['super_admin', 'admin', 'accountant']))
                        <a href="{{ route('payments.index') }}"
                            class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('payments.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-money-check-dollar w-6 text-center"></i>
                            <span class="ml-2">Payments</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        @if (in_array($role, ['super_admin', 'admin', 'accountant']))
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Reports</div>
                <div class="space-y-1">
                    <a href="{{ route('reports.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('reports.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-chart-line w-6 text-center"></i>
                        <span class="ml-2">Analytics & Reports</span>
                    </a>
                </div>
            </div>
        @endif

        @if (in_array($role, ['super_admin', 'admin']))
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Administration
                </div>
                <div class="space-y-1">
                    <a href="{{ route('users.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('users.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-users w-6 text-center"></i>
                        <span class="ml-2">Users & Roles</span>
                    </a>

                    <a href="{{ route('settings.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('settings.*') ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fas fa-cog w-6 text-center"></i>
                        <span class="ml-2">Hospital Settings</span>
                    </a>
                </div>
            </div>
        @endif
    </nav>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const activeItem = document.querySelector('#sidebarNav a.bg-teal-700');
        if (activeItem) {
            activeItem.scrollIntoView({
                block: 'nearest',
                inline: 'nearest'
            });
        }
    });
</script>
