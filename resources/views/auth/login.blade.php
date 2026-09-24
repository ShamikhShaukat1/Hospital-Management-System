<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F766E',
                        secondary: '#14B8A6'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
        <div class="text-center mb-8">
            <div
                class="inline-flex w-14 h-14 rounded-2xl bg-teal-700 text-white items-center justify-center text-2xl mb-3 shadow-lg shadow-teal-700/30">
                <i class="fas fa-hospital-symbol"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">CarePoint Hospital</h2>
            <p class="text-sm text-slate-500 mt-1">Hospital Management System & Portal</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-800 text-sm border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-50 text-rose-800 text-sm border border-rose-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="far fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@example.com') }}"
                        required
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent text-sm">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" value="password" required
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent text-sm">
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember"
                        class="w-4 h-4 text-teal-600 rounded border-slate-300 focus:ring-teal-500">
                    <span class="ml-2">Remember me</span>
                </label>
                <a href="#" class="text-teal-700 hover:underline font-medium">Forgot password?</a>
            </div>

            <button type="submit"
                class="w-full py-2.5 px-4 bg-teal-700 hover:bg-teal-800 text-white font-semibold rounded-lg shadow-md shadow-teal-700/20 transition duration-150 focus:outline-none focus:ring-2 focus:ring-teal-500">
                Sign In to Portal
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-200">
            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3 text-center">
                Demo Accounts (Password: <code class="text-teal-700">password</code>)
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <button type="button" onclick="fillCreds('admin@example.com')"
                    class="p-2 rounded bg-slate-50 hover:bg-teal-50 border border-slate-200 text-slate-700 text-left font-medium">
                    <span class="text-teal-700 font-bold block">Admin</span> admin@example.com
                </button>
                <button type="button" onclick="fillCreds('doctor@example.com')"
                    class="p-2 rounded bg-slate-50 hover:bg-teal-50 border border-slate-200 text-slate-700 text-left font-medium">
                    <span class="text-teal-700 font-bold block">Doctor</span> doctor@example.com
                </button>
                <button type="button" onclick="fillCreds('nurse@example.com')"
                    class="p-2 rounded bg-slate-50 hover:bg-teal-50 border border-slate-200 text-slate-700 text-left font-medium">
                    <span class="text-teal-700 font-bold block">Nurse</span> nurse@example.com
                </button>
                <button type="button" onclick="fillCreds('pharmacist@example.com')"
                    class="p-2 rounded bg-slate-50 hover:bg-teal-50 border border-slate-200 text-slate-700 text-left font-medium">
                    <span class="text-teal-700 font-bold block">Pharmacist</span> pharmacist@example.com
                </button>
            </div>
        </div>
    </div>

    <script>
        function fillCreds(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
        }
    </script>
</body>

</html>
