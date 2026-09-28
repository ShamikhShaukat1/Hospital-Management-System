<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\User;
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
            'items.*.quantity' => 'nullable|integer|min:1',
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
                $qty = $item['quantity'] ?? 1;

                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $item['medicine_id'],
                    'dosage' => $item['dosage'],
                    'frequency' => $item['frequency'],
                    'duration' => $item['duration'],
                    'quantity' => $qty,
                    'instructions' => $item['instructions'] ?? null,
                ]);

                $med = Medicine::find($item['medicine_id']);
                if ($med) {
                    $med->decrement('stock_quantity', $qty);
                }
            }

            DB::commit();

            $prescription->load(['patient', 'doctor']);
            $usersToNotify = $this->getPrescriptionRecipients($prescription);
            $patientName = $prescription->patient?->name ?? 'Patient';

            NotificationHelper::notifyUsers(
                users: $usersToNotify,
                title: 'Prescription Issued',
                message: "A new prescription ({$prescription->prescription_id}) has been issued for {$patientName}.",
                url: route('prescriptions.show', $prescription->id),
                type: 'prescription_created',
                icon: 'fa-prescription',
                color: 'teal'
            );

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
        $prescription->load('items.medicine');
        $patients = Patient::where('status', 'active')->get();
        $doctors = Doctor::where('status', 'active')->get();
        $medicines = Medicine::where('status', 'active')->get();

        return view('prescriptions.edit', compact('prescription', 'patients', 'doctors', 'medicines'));
    }

    public function update(Request $request, Prescription $prescription)
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
            'items.*.quantity' => 'nullable|integer|min:1',
            'items.*.instructions' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $prescription->update([
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $validated['doctor_id'],
                'medical_record_id' => $validated['medical_record_id'] ?? null,
                'prescription_date' => $validated['prescription_date'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $prescription->items()->delete();

            foreach ($validated['items'] as $item) {
                $qty = $item['quantity'] ?? 1;

                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $item['medicine_id'],
                    'dosage' => $item['dosage'],
                    'frequency' => $item['frequency'],
                    'duration' => $item['duration'],
                    'quantity' => $qty,
                    'instructions' => $item['instructions'] ?? null,
                ]);
            }

            DB::commit();

            $prescription->load(['patient', 'doctor']);
            $usersToNotify = $this->getPrescriptionRecipients($prescription);
            $patientName = $prescription->patient?->name ?? 'Patient';

            NotificationHelper::notifyUsers(
                users: $usersToNotify,
                title: 'Prescription Updated',
                message: "Prescription details ({$prescription->prescription_id}) for {$patientName} have been updated.",
                url: route('prescriptions.show', $prescription->id),
                type: 'prescription_updated',
                icon: 'fa-file-pen',
                color: 'blue'
            );

            return redirect()->route('prescriptions.show', $prescription)
                ->with('success', "Prescription {$prescription->prescription_id} updated successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update prescription: ' . $e->getMessage()])->withInput();
        }
    }

    public function delete(Prescription $prescription)
    {
        $prescription->load(['patient', 'doctor', 'items.medicine']);
        return view('prescriptions.delete', compact('prescription'));
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->load(['patient', 'doctor']);
        $usersToNotify = $this->getPrescriptionRecipients($prescription);
        $patientName = $prescription->patient?->name ?? 'Patient';
        $rxNumber = $prescription->prescription_id;

        DB::beginTransaction();
        try {
            $prescription->items()->delete();
            $prescription->delete();
            DB::commit();

            NotificationHelper::notifyUsers(
                users: $usersToNotify,
                title: 'Prescription Cancelled/Deleted',
                message: "Prescription {$rxNumber} for {$patientName} has been deleted.",
                url: route('prescriptions.index'),
                type: 'prescription_deleted',
                icon: 'fa-file-xmark',
                color: 'rose'
            );

            return redirect()->route('prescriptions.index')
                ->with('success', "Prescription {$rxNumber} deleted successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete prescription: ' . $e->getMessage()]);
        }
    }

    private function getPrescriptionRecipients(Prescription $prescription)
    {
        $users = collect();
        $staffUsers = User::whereIn('role', ['super_admin', 'admin', 'doctor', 'pharmacist', 'nurse'])->get();
        $users = $users->merge($staffUsers);

        if ($prescription->doctor?->user) {
            $users->push($prescription->doctor->user);
        }

        if ($prescription->patient?->user) {
            $users->push($prescription->patient->user);
        }

        return $users->unique('id');
    }
}
