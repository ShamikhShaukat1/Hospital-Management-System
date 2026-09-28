@extends('layouts.app')

@section('title', 'Edit Prescription')
@section('page_title', 'Edit Electronic Prescription')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between pb-3 mb-4 border-b">
                <h3 class="text-lg font-bold text-slate-800">
                    Edit Prescription <span class="text-teal-700 font-mono">({{ $prescription->prescription_id }})</span>
                </h3>
                <a href="{{ route('prescriptions.show', $prescription) }}"
                    class="text-sm text-slate-500 hover:text-slate-700">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>

            <form method="POST" action="{{ route('prescriptions.update', $prescription) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Patient *</label>
                        <select name="patient_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">-- Choose Patient --</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ old('patient_id', $prescription->patient_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }} ({{ $patient->patient_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Prescribing Doctor
                            *</label>
                        <select name="doctor_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">-- Choose Doctor --</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}"
                                    {{ old('doctor_id', $prescription->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->name }} ({{ $doctor->specialization }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Prescription Date *</label>
                        <input type="date" name="prescription_date"
                            value="{{ old('prescription_date', $prescription->prescription_date?->format('Y-m-d')) }}"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-teal-700">Prescribed Medications</h4>
                        <button type="button" id="addMedicineBtn"
                            class="px-3 py-1.5 bg-teal-50 text-teal-700 hover:bg-teal-100 rounded-lg text-xs font-semibold">
                            <i class="fas fa-plus mr-1"></i> Add Another Medicine
                        </button>
                    </div>

                    <div id="medicinesContainer" class="space-y-3">
                        @foreach ($prescription->items as $index => $item)
                            <div
                                class="medicine-row p-4 rounded-lg bg-slate-50 border border-slate-200 grid grid-cols-1 md:grid-cols-5 gap-3 relative">
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Select Medicine
                                        *</label>
                                    <select name="items[{{ $index }}][medicine_id]" required
                                        class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                                        <option value="">-- Choose Medicine --</option>
                                        @foreach ($medicines as $med)
                                            <option value="{{ $med->id }}"
                                                {{ $item->medicine_id == $med->id ? 'selected' : '' }}>
                                                {{ $med->name }} ({{ $med->generic_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Dosage *</label>
                                    <input type="text" name="items[{{ $index }}][dosage]"
                                        value="{{ $item->dosage }}" placeholder="e.g. 500mg" required
                                        class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Frequency *</label>
                                    <input type="text" name="items[{{ $index }}][frequency]"
                                        value="{{ $item->frequency }}" placeholder="e.g. 1-0-1" required
                                        class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                                </div>
                                <div class="flex items-end gap-2">
                                    <div class="flex-1">
                                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">Duration
                                            *</label>
                                        <input type="text" name="items[{{ $index }}][duration]"
                                            value="{{ $item->duration }}" placeholder="e.g. 5 days" required
                                            class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                                    </div>
                                    @if ($index > 0)
                                        <button type="button" onclick="this.closest('.medicine-row').remove()"
                                            class="p-1.5 text-rose-500 hover:text-rose-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 border-t">
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Notes / Special
                        Instructions</label>
                    <textarea name="notes" rows="3"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none">{{ old('notes', $prescription->notes) }}</textarea>
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('prescriptions.index') }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm">
                        Update Prescription
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let rowIndex = {{ $prescription->items->count() }};
        document.getElementById('addMedicineBtn').addEventListener('click', function() {
            const container = document.getElementById('medicinesContainer');
            const newRow = document.createElement('div');
            newRow.className =
                'medicine-row p-4 rounded-lg bg-slate-50 border border-slate-200 grid grid-cols-1 md:grid-cols-5 gap-3 relative';
            newRow.innerHTML = `
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Select Medicine *</label>
                    <select name="items[${rowIndex}][medicine_id]" required class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                        <option value="">-- Choose Medicine --</option>
                        @foreach ($medicines as $med)
                            <option value="{{ $med->id }}">{{ $med->name }} ({{ $med->generic_name }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Dosage *</label>
                    <input type="text" name="items[${rowIndex}][dosage]" placeholder="e.g. 500mg" required class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Frequency *</label>
                    <input type="text" name="items[${rowIndex}][frequency]" placeholder="e.g. 1-0-1" required class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                </div>
                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">Duration *</label>
                        <input type="text" name="items[${rowIndex}][duration]" placeholder="e.g. 7 days" required class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                    </div>
                    <button type="button" onclick="this.closest('.medicine-row').remove()" class="p-1.5 text-rose-500 hover:text-rose-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
            rowIndex++;
        });
    </script>
@endsection
