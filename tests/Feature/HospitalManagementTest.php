<?php

namespace Tests\Feature;

use App\Models\Admission;
use App\Models\Bed;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HospitalManagementTest extends TestCase
{
    use RefreshDatabase;

    /** Test user authentication and login redirect */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@carepoint.org',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@carepoint.org',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** Test role-based protection redirects unauthorized roles */
    public function test_patient_cannot_access_user_management(): void
    {
        $patientUser = User::factory()->create(['role' => 'patient']);

        $response = $this->actingAs($patientUser)->get('/users');

        $response->assertStatus(403);
    }

    /** Test patient registration CRUD */
    public function test_admin_can_create_patient(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/patients', [
            'name' => 'Alice Cooper',
            'gender' => 'Female',
            'date_of_birth' => '1990-05-12',
            'blood_group' => 'O+',
            'phone' => '+15559998888',
            'email' => 'alice@test.com',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('patients', [
            'name' => 'Alice Cooper',
            'email' => 'alice@test.com',
        ]);

        $patient = Patient::where('email', 'alice@test.com')->first();
        $this->assertNotNull($patient->patient_id);
        $this->assertStringStartsWith('PAT-', $patient->patient_id);
    }

    /** Test admission changes bed status to Occupied and discharge frees bed */
    public function test_admission_and_discharge_workflow_updates_bed_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $dept = Department::create(['name' => 'General Medicine', 'status' => 'active']);
        $room = Room::create(['room_number' => '201', 'room_type' => 'Private', 'floor' => 2, 'status' => 'available']);
        $bed = Bed::create(['bed_number' => '201-A', 'room_id' => $room->id, 'status' => 'Available']);
        
        $doctor = Doctor::create([
            'doctor_id' => 'DOC-0099',
            'department_id' => $dept->id,
            'name' => 'Dr. Test',
            'email' => 'testdr@hospital.com',
            'phone' => '1234567890',
            'specialization' => 'Physician',
            'qualification' => 'MD',
            'consultation_fee' => 50,
            'status' => 'active'
        ]);

        $patient = Patient::create([
            'patient_id' => 'PAT-00999',
            'name' => 'Test Patient',
            'gender' => 'Male',
            'date_of_birth' => '1980-01-01',
            'phone' => '9998887777',
            'status' => 'active',
        ]);

        // 1. Admit patient
        $this->actingAs($admin)->post('/admissions', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'room_id' => $room->id,
            'bed_id' => $bed->id,
            'admission_date' => now()->toDateString(),
            'reason' => 'Observation',
            'diagnosis' => 'Dehydration',
        ]);

        $bed->refresh();
        $this->assertEquals('Occupied', $bed->status);

        $admission = Admission::where('patient_id', $patient->id)->first();
        $this->assertEquals('Admitted', $admission->status);

        // 2. Discharge patient
        $this->actingAs($admin)->post('/discharges', [
            'admission_id' => $admission->id,
            'discharge_date' => now()->toDateString(),
            'discharge_time' => '12:00:00',
            'diagnosis' => 'Resolved Dehydration',
            'treatment_summary' => 'IV fluids administered',
            'instructions' => 'Hydrate at home',
        ]);

        $bed->refresh();
        $this->assertEquals('Available', $bed->status);

        $admission->refresh();
        $this->assertEquals('Discharged', $admission->status);
    }
}
