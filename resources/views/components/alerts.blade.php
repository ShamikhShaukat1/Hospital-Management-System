@if (session('success'))
    <div class="mb-6 flex items-start justify-between gap-4 rounded-xl border border-teal-200 bg-teal-50 px-5 py-4 text-sm text-teal-800"
        role="alert">
        <p class="flex-1 font-medium">{{ session('success') }}</p>

        <button type="button" onclick="this.parentElement.remove()"
            class="shrink-0 text-teal-600 hover:text-teal-900 text-xl font-bold leading-none transition"
            aria-label="Close success message">
            &times;
        </button>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 flex items-start justify-between gap-4 rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800"
        role="alert">
        <p class="flex-1 font-medium">{{ session('error') }}</p>

        <button type="button" onclick="this.parentElement.remove()"
            class="shrink-0 text-rose-600 hover:text-rose-900 text-xl font-bold leading-none transition"
            aria-label="Close error message">
            &times;
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 flex items-start justify-between gap-4 rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800"
        role="alert">
        <div class="flex-1">
            <p class="font-semibold mb-2">Please correct the following errors:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <button type="button" onclick="this.parentElement.remove()"
            class="shrink-0 text-rose-600 hover:text-rose-900 text-xl font-bold leading-none transition"
            aria-label="Close validation errors">
            &times;
        </button>
    </div>
@endif
