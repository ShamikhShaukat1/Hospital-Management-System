@extends('layouts.app')

@section('title', 'Write Prescription')
@section('page_title', 'Create Electronic Prescription')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <h3 class="text-lg font-bold text-slate-800 pb-3 mb-4 border-b">Electronic Prescription (Rx)</h3>

            <form method="POST" action="{{ route('prescriptions.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Patient *</label>
                        <select name="patient_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-600 focus:outline-none">
                            <option value="">-- Choose Patient --</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ old('patient_id', $selectedPatientId) == $patient->id ? 'selected' : '' }}>
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
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->name }} ({{ $doctor->specialization }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Prescription Date *</label>
                        <input type="date" name="prescription_date" value="{{ old('prescription_date', date('Y-m-d')) }}"
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
                        <div
                            class="medicine-row p-4 rounded-lg bg-slate-50 border border-slate-200 grid grid-cols-1 md:grid-cols-5 gap-3">
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Select Medicine *</label>
                                <select name="items[0][medicine_id]" required
                                    class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                                    <option value="">-- Choose Medicine --</option>
                                    @foreach ($medicines as $med)
                                        <option value="{{ $med->id }}">{{ $med->name }} ({{ $med->generic_name }}
                                            - {{ $med->category }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Dosage *</label>
                                <input type="text" name="items[0][dosage]" placeholder="e.g. 500mg" required
                                    class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Frequency *</label>
                                <input type="text" name="items[0][frequency]" placeholder="e.g. 1-0-1 after food"
                                    required class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Duration *</label>
                                <input type="text" name="items[0][duration]" placeholder="e.g. 5 days" required
                                    class="w-full px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t">
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">General Advice & Patient
                        Instructions</label>
                    <textarea name="instructions" rows="3" placeholder="Drink plenty of fluids, rest, avoid cold drinks..."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:outline-none"></textarea>
                </div>

                <div class="pt-4 border-t flex justify-end gap-2">
                    <a href="{{ route('prescriptions.index') }}"
                        class="px-4 py-2 border rounded-lg text-sm font-semibold text-slate-700">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-lg text-sm font-semibold shadow-sm">Issue
                        Prescription</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let rowIndex = 1;
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
