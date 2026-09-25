<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'department']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('patient_id', 'like', "%{$search}%");
            })->orWhereHas('doctor', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->latest('appointment_date')->paginate(10)->withQueryString();
        $doctors = Doctor::where('status', 'active')->get();

        return view('appointments.index', compact('appointments', 'doctors'));
    }

    public function create()
    {
        $patients = Patient::where('status', 'active')->get();
        $doctors = Doctor::with('department')->where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();

        return view('appointments.create', compact('patients', 'doctors', 'departments'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $existing = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->first();

        if ($existing) {
            return back()->withErrors([
                'appointment_time' => 'Doctor already has a scheduled appointment at this date and time slot.',
            ])->withInput();
        }

        $lastApp = Appointment::latest('id')->first();
        $nextNum = $lastApp ? ($lastApp->id + 1) : 1;
        $appointmentId = 'APT-' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);

        $appointment = Appointment::create(array_merge(
            $request->validated(),
            ['appointment_id' => $appointmentId]
        ));

        $appointment->load(['patient', 'doctor', 'department']);

        $usersToNotify = $this->getAppointmentRecipients($appointment);

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'New Appointment Scheduled',
            message: "New appointment ({$appointment->appointment_id}) has been created.",
            url: route('appointments.show', $appointment->id),
            type: 'appointment_created',
            icon: 'fa-calendar-plus',
            color: 'emerald'
        );

        return redirect()->route('appointments.show', $appointment)
            ->with('success', "Appointment {$appointment->appointment_id} scheduled successfully.");
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor.department', 'medicalRecord']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::where('status', 'active')->get();
        $doctors = Doctor::where('status', 'active')->get();
        $departments = Department::where('status', 'active')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'departments'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'nullable|exists:departments,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'reason' => 'required|string|max:255',
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);
        $appointment->load(['patient', 'doctor', 'department']);
        $usersToNotify = $this->getAppointmentRecipients($appointment);

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Appointment Updated',
            message: "Appointment ({$appointment->appointment_id}) details have been updated.",
            url: route('appointments.show', $appointment->id),
            type: 'appointment_updated',
            icon: 'fa-calendar-pen',
            color: 'blue'
        );

        return redirect()->route('appointments.show', $appointment)
            ->with('success', "Appointment updated successfully.");
    }

    public function delete(Appointment $appointment)
    {
        return view('appointments.delete', compact('appointment'));
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'department']);
        $usersToNotify = $this->getAppointmentRecipients($appointment);
        $appointmentId = $appointment->appointment_id;

        $appointment->delete();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Appointment Cancelled',
            message: "Appointment {$appointmentId} has been cancelled and removed.",
            url: route('appointments.index'),
            type: 'appointment_deleted',
            icon: 'fa-calendar-xmark',
            color: 'rose'
        );

        return redirect()->route('appointments.index')
            ->with('success', "Appointment cancelled and removed.");
    }

    private function getAppointmentRecipients(Appointment $appointment)
    {
        $users = collect();

        $adminUsers = User::whereIn('role', ['super_admin', 'admin'])->get();
        $users = $users->merge($adminUsers);

        if ($appointment->doctor?->user) {
            $users->push($appointment->doctor->user);
        }

        if ($appointment->patient?->user) {
            $users->push($appointment->patient->user);
        }

        return $users->unique('id');
    }
}
