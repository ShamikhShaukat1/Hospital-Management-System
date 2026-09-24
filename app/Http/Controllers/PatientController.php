<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('patient_id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $patients = $query->latest()->paginate(15)->withQueryString();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(StorePatientRequest $request)
    {
        $lastPatient = Patient::withTrashed()->latest('id')->first();
        $nextNum = $lastPatient ? ($lastPatient->id + 1) : 1;
        $patientId = 'PAT-' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);

        $patient = Patient::create(array_merge(
            $request->validated(),
            ['patient_id' => $patientId]
        ));

        return redirect()->route('patients.show', $patient)
            ->with('success', "Patient {$patient->name} ({$patient->patient_id}) created successfully.");
    }

    public function show(Patient $patient)
    {
        $patient->load([
            'appointments.doctor',
            'medicalRecords.doctor',
            'prescriptions.doctor',
            'prescriptions.items.medicine',
            'admissions.doctor',
            'admissions.room',
            'admissions.bed',
            'discharges',
            'invoices.payments',
            'payments'
        ]);

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(StorePatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        return redirect()->route('patients.show', $patient)
            ->with('success', "Patient {$patient->name} updated successfully.");
    }

    public function delete(Patient $patient)
    {
        return view('patients.delete', compact('patient'));
    }

    public function destroy(Patient $patient)
    {
        $name = $patient->name;
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', "Patient record for {$name} deleted successfully.");
    }
}
