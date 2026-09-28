<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor', 'appointment']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('patient_id', 'like', "%{$search}%");
            })->orWhere('diagnosis', 'like', "%{$search}%");
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        $medicalRecords = $query->latest('record_date')->paginate(15)->withQueryString();
        $doctors = Doctor::where('status', 'active')->get();

        return view('medical-records.index', compact('medicalRecords', 'doctors'));
    }

    public function create(Request $request)
    {
        $patients = Patient::where('status', 'active')->get();
        $doctors = Doctor::where('status', 'active')->get();
        $selectedPatientId = $request->input('patient_id');

        return view('medical-records.create', compact('patients', 'doctors', 'selectedPatientId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'diagnosis' => 'required|string|max:255',
            'symptoms' => 'nullable|string',
            'treatment' => 'nullable|string',
            'notes' => 'nullable|string',
            'record_date' => 'required|date',
        ]);

        $record = MedicalRecord::create($validated);
        $record->load(['patient', 'doctor']);

        $usersToNotify = $this->getMedicalRecordRecipients($record);
        $patientName = $record->patient?->name ?? 'Patient';

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Medical Record Logged',
            message: "A new medical record ({$record->diagnosis}) has been logged for {$patientName}.",
            url: route('medical-records.show', $record->id),
            type: 'medical_record_created',
            icon: 'fa-file-medical',
            color: 'teal'
        );

        return redirect()->route('medical-records.show', $record)
            ->with('success', "Medical record added successfully.");
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'appointment', 'prescription.items.medicine']);
        return view('medical-records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $patients = Patient::where('status', 'active')->get();
        $doctors = Doctor::where('status', 'active')->get();

        return view('medical-records.edit', compact('medicalRecord', 'patients', 'doctors'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'diagnosis' => 'required|string|max:255',
            'symptoms' => 'nullable|string',
            'treatment' => 'nullable|string',
            'notes' => 'nullable|string',
            'record_date' => 'required|date',
        ]);

        $medicalRecord->update($validated);
        $medicalRecord->load(['patient', 'doctor']);

        $usersToNotify = $this->getMedicalRecordRecipients($medicalRecord);
        $patientName = $medicalRecord->patient?->name ?? 'Patient';

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Medical Record Updated',
            message: "Medical record details for {$patientName} have been updated.",
            url: route('medical-records.show', $medicalRecord->id),
            type: 'medical_record_updated',
            icon: 'fa-file-pen',
            color: 'blue'
        );

        return redirect()->route('medical-records.show', $medicalRecord)
            ->with('success', "Medical record updated successfully.");
    }

    public function delete(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor']);
        return view('medical-records.delete', compact('medicalRecord'));
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor']);
        $usersToNotify = $this->getMedicalRecordRecipients($medicalRecord);
        $patientName = $medicalRecord->patient?->name ?? 'Patient';
        $diagnosis = $medicalRecord->diagnosis;

        $medicalRecord->delete();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Medical Record Removed',
            message: "The medical record ({$diagnosis}) for {$patientName} has been deleted.",
            url: route('medical-records.index'),
            type: 'medical_record_deleted',
            icon: 'fa-file-xmark',
            color: 'rose'
        );

        return redirect()->route('medical-records.index')
            ->with('success', "Medical record deleted successfully.");
    }

    private function getMedicalRecordRecipients(MedicalRecord $record)
    {
        $users = collect();
        $staffUsers = User::whereIn('role', ['super_admin', 'admin', 'doctor', 'nurse'])->get();
        $users = $users->merge($staffUsers);

        if ($record->doctor?->user) {
            $users->push($record->doctor->user);
        }

        if ($record->patient?->user) {
            $users->push($record->patient->user);
        }

        return $users->unique('id');
    }
}
