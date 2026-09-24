<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prescription::with(['patient', 'doctor', 'items.medicine']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('patient_id', 'like', "%{$search}%");
            })->orWhere('prescription_id', 'like', "%{$search}%");
        }

        $prescriptions = $query->latest('prescription_date')->paginate(15)->withQueryString();

        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create(Request $request)
    {
        $patients = Patient::where('status', 'active')->get();
        $doctors = Doctor::where('status', 'active')->get();
        $medicines = Medicine::where('status', 'active')->where('stock_quantity', '>', 0)->get();
        $medicalRecords = MedicalRecord::latest()->take(20)->get();
        $selectedPatientId = $request->input('patient_id');

        return view('prescriptions.create', compact('patients', 'doctors', 'medicines', 'medicalRecords', 'selectedPatientId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'medical_record_id' => 'nullable|exists:medical_records,id',
            'prescription_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.dosage' => 'required|string|max:100',
            'items.*.frequency' => 'required|string|max:100',
            'items.*.duration' => 'required|string|max:100',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.instructions' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $lastRx = Prescription::latest('id')->first();
            $nextNum = $lastRx ? ($lastRx->id + 1) : 1;
            $prescriptionId = 'RX-' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);

            $prescription = Prescription::create([
                'prescription_id' => $prescriptionId,
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $validated['doctor_id'],
                'medical_record_id' => $validated['medical_record_id'] ?? null,
                'prescription_date' => $validated['prescription_date'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'active',
            ]);

            foreach ($validated['items'] as $item) {
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $item['medicine_id'],
                    'dosage' => $item['dosage'],
                    'frequency' => $item['frequency'],
                    'duration' => $item['duration'],
                    'quantity' => $item['quantity'],
                    'instructions' => $item['instructions'] ?? null,
                ]);

                // Deduct stock if available
                $med = Medicine::find($item['medicine_id']);
                if ($med) {
                    $med->decrement('stock_quantity', $item['quantity']);
                }
            }

            DB::commit();

            return redirect()->route('prescriptions.show', $prescription)
                ->with('success', "Prescription {$prescription->prescription_id} issued successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to issue prescription: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient', 'doctor.department', 'medicalRecord', 'items.medicine']);
        return view('prescriptions.show', compact('prescription'));
    }

    public function edit(Prescription $prescription)
    {
        $prescription->load('items');
        $patients = Patient::where('status', 'active')->get();
        $doctors = Doctor::where('status', 'active')->get();
        $medicines = Medicine::where('status', 'active')->get();

        return view('prescriptions.edit', compact('prescription', 'patients', 'doctors', 'medicines'));
    }
}
