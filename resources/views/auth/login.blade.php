<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarePoint Hospital - Management System Login</title>
    <link rel="icon" type="image/png" href="{{ asset('carepoint-favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#0F766E',
                            hover: '#115E59',
                            light: '#F0FDFA'
                        },
                        secondary: '#14B8A6'
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="h-full bg-slate-900 font-sans antialiased text-slate-800 selection:bg-teal-500 selection:text-white">
    <div class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-12">
        <div
            class="lg:col-span-7 relative bg-slate-900 hidden lg:flex flex-col justify-between p-12 lg:p-16 overflow-hidden min-h-screen select-none">

            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&q=80&w=1600"
                    alt="CarePoint Hospital Facility"
                    class="w-full h-full object-cover opacity-30 filter brightness-90">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-teal-950/85 to-slate-900/70"></div>
            </div>

            <div class="relative z-10 flex items-center gap-3.5">
                <div
                    class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white text-2xl shadow-xl">
                    <i class="fas fa-hospital-symbol text-secondary"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-wide">CarePoint</h1>
                    <p class="text-xs text-teal-200/80 uppercase tracking-widest font-semibold">Hospital Management
                        System</p>
                </div>
            </div>

            <div class="relative z-10 my-auto py-12 max-w-xl">
                <span
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-medium bg-teal-500/20 text-teal-300 border border-teal-500/30 mb-6 backdrop-blur-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Smart Hospital Management Portal
                </span>
                <h2 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-6">
                    Excellence in Patient Care &amp; Clinical Operations
                </h2>
                <p class="text-teal-100/80 text-base leading-relaxed mb-10">
                    A unified workspace empowering healthcare professionals to manage medical records, patient care, and
                    administrative tasks seamlessly.
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10">
                        <div class="text-secondary text-xl mb-2"><i class="fas fa-shield-heart"></i></div>
                        <h3 class="text-sm font-semibold text-white">HIPAA Compliant</h3>
                        <p class="text-xs text-teal-200/70 mt-0.5">Enterprise medical data security</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10">
                        <div class="text-secondary text-xl mb-2"><i class="fas fa-user-md"></i></div>
                        <h3 class="text-sm font-semibold text-white">Multi-Role Access</h3>
                        <p class="text-xs text-teal-200/70 mt-0.5">Tailored dashboards for staff</p>
                    </div>
                </div>
            </div>

            <div
                class="relative z-10 pt-6 border-t border-white/10 flex items-center justify-between text-xs text-teal-200/60">
                <span>© 2026 CarePoint Hospital Network</span>
            </div>
        </div>

        <div class="lg:col-span-5 bg-white p-6 sm:p-12 lg:p-16 flex flex-col justify-between min-h-screen">
            <div class="flex lg:hidden items-center justify-center gap-3 mb-8 text-center">
                <div
                    class="w-12 h-12 rounded-2xl bg-primary text-white flex items-center justify-center text-2xl shadow-lg shadow-teal-700/20">
                    <i class="fas fa-hospital-symbol"></i>
                </div>
                <div class="text-left">
                    <h2 class="text-xl font-bold text-slate-800">CarePoint</h2>
                    <p class="text-xs text-slate-500">Hospital Portal</p>
                </div>
            </div>

            <div class="my-auto max-w-md mx-auto w-full">
                <div class="mb-6">
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Sign In</h3>
                    <p class="text-sm text-slate-500 mt-1">Welcome back! Access your portal account below.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 flex items-start gap-3">
                        <div class="text-red-500 mt-0.5">
                            <i class="fas fa-circle-exclamation text-sm"></i>
                        </div>
                        <div class="text-xs font-medium text-red-700">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Quick Select
                            Role</span>
                        <span
                            class="text-[11px] font-medium text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-100">Demo
                            Mode</span>
                    </div>
                    <div class="grid grid-cols-4 gap-1.5 p-1 bg-slate-100 rounded-xl border border-slate-200/60">
                        <button type="button" id="role-admin" onclick="fillRole('admin@carepoint.org', 'admin')"
                            class="role-btn py-2 text-xs font-semibold rounded-lg transition-all text-white bg-primary shadow-sm shadow-teal-700/20">
                            Admin
                        </button>
                        <button type="button" id="role-doctor" onclick="fillRole('doctor@carepoint.org', 'doctor')"
                            class="role-btn py-2 text-xs font-medium rounded-lg transition-all text-slate-600 hover:text-slate-900">
                            Doctor
                        </button>
                        <button type="button" id="role-nurse" onclick="fillRole('nurse@carepoint.org', 'nurse')"
                            class="role-btn py-2 text-xs font-medium rounded-lg transition-all text-slate-600 hover:text-slate-900">
                            Nurse
                        </button>
                        <button type="button" id="role-pharmacist"
                            onclick="fillRole('pharmacist@carepoint.org', 'pharmacist')"
                            class="role-btn py-2 text-xs font-medium rounded-lg transition-all text-slate-600 hover:text-slate-900">
                            Pharmacy
                        </button>
                    </div>
                </div>

                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-medium text-slate-600 mb-1">Email
                            Address</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-slate-400 pointer-events-none">
                                <i class="far fa-envelope text-sm"></i>
                            </span>
                            <input type="email" id="email" name="email" value="admin@carepoint.org" required
                                placeholder="name@carepoint.org"
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition duration-150">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-xs font-medium text-slate-600">Password</label>
                            <a href="#" class="text-xs text-primary font-medium hover:underline">Forgot
                                password?</a>
                        </div>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-slate-400 pointer-events-none">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input type="password" id="password" name="password" value="password" required
                                class="w-full pl-11 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition duration-150">
                            <button type="button" onclick="togglePasswordVisibility()"
                                aria-label="Toggle password visibility"
                                class="absolute right-3.5 text-slate-400 hover:text-slate-600 p-1 rounded-md transition">
                                <i id="eye-icon" class="far fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center pt-1">
                        <label class="flex items-center text-slate-600 cursor-pointer group">
                            <input type="checkbox" name="remember" checked
                                class="w-4 h-4 text-primary rounded border-slate-300 focus:ring-primary cursor-pointer accent-teal-700">
                            <span
                                class="ml-2.5 text-xs font-medium text-slate-600 group-hover:text-slate-800 transition">
                                Keep me signed in
                            </span>
                        </label>
                    </div>
                    &nbsp;

                    <button type="submit"
                        class="w-full py-3.5 px-5 bg-primary hover:bg-primary-hover active:scale-[0.99] text-white font-semibold rounded-xl shadow-md shadow-teal-700/15 transition duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 flex items-center justify-center gap-2 text-sm">
                        <span>Sign In to Dashboard</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </button>
                </form>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-400">
                    Need technical assistance?
                    <a href="#" class="text-slate-600 font-medium hover:underline">Contact IT Support</a>
                </p>
            </div>

        </div>
    </div>

    <script>
        function fillRole(email, roleKey) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';

            document.querySelectorAll('.role-btn').forEach(btn => {
                btn.className =
                    'role-btn py-2 text-xs font-medium rounded-lg transition-all text-slate-600 hover:text-slate-900';
            });

            const activeBtn = document.getElementById(`role-${roleKey}`);
            if (activeBtn) {
                activeBtn.className =
                    'role-btn py-2 text-xs font-semibold rounded-lg transition-all bg-primary text-white shadow-sm shadow-teal-700/20';
            }
        }

        function togglePasswordVisibility() {
            const passInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeIcon.className = 'far fa-eye-slash text-sm';
            } else {
                passInput.type = 'password';
                eyeIcon.className = 'far fa-eye text-sm';
            }
        }
    </script>
</body>

</html>
