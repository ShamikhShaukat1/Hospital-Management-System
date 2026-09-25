<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Http\Requests\StoreDoctorRequest;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with('department');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('doctor_id', 'like', "%{$search}%")
                    ->orWhere('specialization', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $doctors = $query->latest()->paginate(10)->withQueryString();
        $departments = Department::where('status', 'active')->get();

        return view('doctors.index', compact('doctors', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('status', 'active')->get();
        return view('doctors.create', compact('departments'));
    }

    public function store(StoreDoctorRequest $request)
    {
        $lastDoc = Doctor::latest('id')->first();
        $nextNum = $lastDoc ? ($lastDoc->id + 1) : 1;
        $doctorId = 'DOC-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        $doctor = Doctor::create(array_merge(
            $request->validated(),
            ['doctor_id' => $doctorId]
        ));

        $doctor->load(['department', 'user']);
        $usersToNotify = $this->getDoctorRecipients($doctor);

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'New Doctor Added',
            message: "Dr. {$doctor->name} ({$doctor->doctor_id}) has been added to {$doctor->department?->name}.",
            url: route('doctors.show', $doctor->id),
            type: 'doctor_created',
            icon: 'fa-user-md',
            color: 'emerald'
        );

        return redirect()->route('doctors.show', $doctor)
            ->with('success', "Doctor {$doctor->name} ({$doctor->doctor_id}) added successfully.");
    }

    public function show(Doctor $doctor)
    {
        $doctor->load([
            'department',
            'appointments.patient',
            'medicalRecords.patient',
            'prescriptions.patient'
        ]);

        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::where('status', 'active')->get();
        return view('doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'specialization' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'address' => 'nullable|string',
            'consultation_fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $doctor->update($validated);
        $doctor->load(['department', 'user']);
        $usersToNotify = $this->getDoctorRecipients($doctor);

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Doctor Profile Updated',
            message: "Profile details for Dr. {$doctor->name} ({$doctor->doctor_id}) have been updated.",
            url: route('doctors.show', $doctor->id),
            type: 'doctor_updated',
            icon: 'fa-user-doctor',
            color: 'blue'
        );

        return redirect()->route('doctors.show', $doctor)
            ->with('success', "Doctor {$doctor->name} updated successfully.");
    }

    public function delete(Doctor $doctor)
    {
        return view('doctors.delete', compact('doctor'));
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->load(['department', 'user']);

        $doctorName = $doctor->name;
        $doctorId = $doctor->doctor_id;
        $usersToNotify = $this->getDoctorRecipients($doctor);

        $doctor->delete();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Doctor Record Removed',
            message: "Doctor record for Dr. {$doctorName} ({$doctorId}) was removed.",
            url: route('doctors.index'),
            type: 'doctor_deleted',
            icon: 'fa-user-slash',
            color: 'rose'
        );

        return redirect()->route('doctors.index')
            ->with('success', "Doctor {$doctorName} record deleted successfully.");
    }

    private function getDoctorRecipients(Doctor $doctor)
    {
        $users = collect();
        $staffUsers = User::whereIn('role', ['super_admin', 'admin', 'hr', 'staff'])->get();
        $users = $users->merge($staffUsers);

        if ($doctor->user) {
            $users->push($doctor->user);
        }

        return $users->unique('id');
    }
}
