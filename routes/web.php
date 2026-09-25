<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\DischargeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\NotificationController;

// Home
Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    /*
    |--------------------------------------------------------------------------
    | Patients
    |--------------------------------------------------------------------------
    */

    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::get('/patients/{patient}/delete', [PatientController::class, 'delete'])->name('patients.delete');

    /*
    |--------------------------------------------------------------------------
    | Doctors
    |--------------------------------------------------------------------------
    */

    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
    Route::get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
    Route::get('/doctors/{doctor}/delete', [DoctorController::class, 'delete'])->name('doctors.delete');

    /*
    |--------------------------------------------------------------------------
    | Departments
    |--------------------------------------------------------------------------
    */

    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
    Route::get('/departments/{department}/delete', [DepartmentController::class, 'delete'])->name('departments.delete');

    /*
    |--------------------------------------------------------------------------
    | Appointments
    |--------------------------------------------------------------------------
    */

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/appointments/{appointment}/delete', [AppointmentController::class, 'delete'])->name('appointments.delete');

    /*
    |--------------------------------------------------------------------------
    | Medical Records
    |--------------------------------------------------------------------------
    */

    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/medical-records/create', [MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/medical-records/{medical_record}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
    Route::get('/medical-records/{medical_record}/edit', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
    Route::put('/medical-records/{medical_record}', [MedicalRecordController::class, 'update'])->name('medical-records.update');
    Route::delete('/medical-records/{medical_record}', [MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');

    /*
    |--------------------------------------------------------------------------
    | Prescriptions
    |--------------------------------------------------------------------------
    */

    Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
    Route::get('/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
    Route::post('/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
    Route::get('/prescriptions/{prescription}/edit', [PrescriptionController::class, 'edit'])->name('prescriptions.edit');
    Route::put('/prescriptions/{prescription}', [PrescriptionController::class, 'update'])->name('prescriptions.update');
    Route::delete('/prescriptions/{prescription}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');

    /*
    |--------------------------------------------------------------------------
    | Medicines
    |--------------------------------------------------------------------------
    */

    Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
    Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
    Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
    Route::get('/medicines/{medicine}', [MedicineController::class, 'show'])->name('medicines.show');
    Route::get('/medicines/{medicine}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
    Route::put('/medicines/{medicine}', [MedicineController::class, 'update'])->name('medicines.update');
    Route::delete('/medicines/{medicine}', [MedicineController::class, 'destroy'])->name('medicines.destroy');
    Route::get('/medicines/{medicine}/delete', [MedicineController::class, 'delete'])->name('medicines.delete');

    /*
    |--------------------------------------------------------------------------
    | Nurses
    |--------------------------------------------------------------------------
    */

    Route::get('/nurses', [NurseController::class, 'index'])->name('nurses.index');
    Route::get('/nurses/create', [NurseController::class, 'create'])->name('nurses.create');
    Route::post('/nurses', [NurseController::class, 'store'])->name('nurses.store');
    Route::get('/nurses/{nurse}', [NurseController::class, 'show'])->name('nurses.show');
    Route::get('/nurses/{nurse}/edit', [NurseController::class, 'edit'])->name('nurses.edit');
    Route::put('/nurses/{nurse}', [NurseController::class, 'update'])->name('nurses.update');
    Route::delete('/nurses/{nurse}', [NurseController::class, 'destroy'])->name('nurses.destroy');
    Route::get('/nurses/{nurse}/delete', [NurseController::class, 'delete'])->name('nurses.delete');

    /*
    |--------------------------------------------------------------------------
    | Staff
    |--------------------------------------------------------------------------
    */

    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
    Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::get('/staff/{staff}/delete', [StaffController::class, 'delete'])->name('staff.delete');

    /*
    |--------------------------------------------------------------------------
    | Rooms
    |--------------------------------------------------------------------------
    */

    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::get('/rooms/{room}/delete', [RoomController::class, 'delete'])->name('rooms.delete');

    /*
    |--------------------------------------------------------------------------
    | Beds
    |--------------------------------------------------------------------------
    */

    Route::get('/beds', [BedController::class, 'index'])->name('beds.index');
    Route::get('/beds/create', [BedController::class, 'create'])->name('beds.create');
    Route::post('/beds', [BedController::class, 'store'])->name('beds.store');
    Route::get('/beds/{bed}', [BedController::class, 'show'])->name('beds.show');
    Route::get('/beds/{bed}/edit', [BedController::class, 'edit'])->name('beds.edit');
    Route::put('/beds/{bed}', [BedController::class, 'update'])->name('beds.update');
    Route::delete('/beds/{bed}', [BedController::class, 'destroy'])->name('beds.destroy');
    Route::get('/beds/{bed}/delete', [BedController::class, 'delete'])->name('beds.delete');

    /*
    |--------------------------------------------------------------------------
    | Admissions
    |--------------------------------------------------------------------------
    */

    Route::get('/admissions', [AdmissionController::class, 'index'])->name('admissions.index');
    Route::get('/admissions/create', [AdmissionController::class, 'create'])->name('admissions.create');
    Route::post('/admissions', [AdmissionController::class, 'store'])->name('admissions.store');
    Route::get('/admissions/{admission}', [AdmissionController::class, 'show'])->name('admissions.show');
    Route::get('/admissions/{admission}/edit', [AdmissionController::class, 'edit'])->name('admissions.edit');
    Route::put('/admissions/{admission}', [AdmissionController::class, 'update'])->name('admissions.update');
    Route::delete('/admissions/{admission}', [AdmissionController::class, 'destroy'])->name('admissions.destroy');

    /*
    |--------------------------------------------------------------------------
    | Discharges
    |--------------------------------------------------------------------------
    | Only: index, create, store, show
    |--------------------------------------------------------------------------
    */

    Route::get('/discharges', [DischargeController::class, 'index'])->name('discharges.index');
    Route::get('/discharges/create', [DischargeController::class, 'create'])->name('discharges.create');
    Route::post('/discharges', [DischargeController::class, 'store'])->name('discharges.store');
    Route::get('/discharges/{discharge}', [DischargeController::class, 'show'])->name('discharges.show');

    /*
    |--------------------------------------------------------------------------
    | Billing / Invoices
    |--------------------------------------------------------------------------
    */

    Route::get('/billing', [InvoiceController::class, 'index'])->name('billing.index');
    Route::get('/billing/create', [InvoiceController::class, 'create'])->name('billing.create');
    Route::post('/billing', [InvoiceController::class, 'store'])->name('billing.store');
    Route::get('/billing/{invoice}', [InvoiceController::class, 'show'])->name('billing.show');
    Route::get('/billing/{invoice}/edit', [InvoiceController::class, 'edit'])->name('billing.edit');
    Route::put('/billing/{invoice}', [InvoiceController::class, 'update'])->name('billing.update');
    Route::delete('/billing/{invoice}', [InvoiceController::class, 'destroy'])->name('billing.destroy');
    Route::get('/billing/{invoice}/delete', [InvoiceController::class, 'delete'])->name('billing.delete');

    /*
    |--------------------------------------------------------------------------
    | Payments
    |--------------------------------------------------------------------------
    | Only: index, create, store, show
    |--------------------------------------------------------------------------
    */

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/patients', [ReportController::class, 'patients'])->name('patients');
        Route::get('/doctors', [ReportController::class, 'doctors'])->name('doctors');
        Route::get('/appointments', [ReportController::class, 'appointments'])->name('appointments');
        Route::get('/admissions', [ReportController::class, 'admissions'])->name('admissions');
        Route::get('/billing', [ReportController::class, 'billing'])->name('billing');
        Route::get('/payments', [ReportController::class, 'payments'])->name('payments');
        Route::get('/medicines', [ReportController::class, 'medicines'])->name('medicines');
    });

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});
