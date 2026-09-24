<?php

namespace Database\Seeders;

use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Bed;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\HospitalSetting;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Room;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hospital Settings
        $settings = [
            'hospital_name' => 'CarePoint General Hospital',
            'hospital_email' => 'contact@carepoint-health.org',
            'hospital_phone' => '+1 (555) 019-2834',
            'hospital_address' => '742 Evergreen Terrace, Medical District, Springfield',
            'tax_percentage' => '5.0',
            'currency_symbol' => '$',
            'emergency_hotline' => '911 / (555) 019-9999',
        ];
        foreach ($settings as $k => $v) {
            HospitalSetting::create(['key' => $k, 'value' => $v]);
        }

        // 2. Users (All 8 Roles)
        $defaultPassword = Hash::make('password');

        $users = [
            [
                'name' => 'Dr. Eleanor Vance (Super Admin)',
                'email' => 'superadmin@example.com',
                'password' => $defaultPassword,
                'role' => 'super_admin',
                'phone' => '+1 (555) 100-0001',
                'status' => 'active',
            ],
            [
                'name' => 'Marcus Sterling (Hospital Admin)',
                'email' => 'admin@example.com',
                'password' => $defaultPassword,
                'role' => 'admin',
                'phone' => '+1 (555) 100-0002',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Gregory House',
                'email' => 'doctor@example.com',
                'password' => $defaultPassword,
                'role' => 'doctor',
                'phone' => '+1 (555) 100-0003',
                'status' => 'active',
            ],
            [
                'name' => 'Nurse Clara Barton',
                'email' => 'nurse@example.com',
                'password' => $defaultPassword,
                'role' => 'nurse',
                'phone' => '+1 (555) 100-0004',
                'status' => 'active',
            ],
            [
                'name' => 'Sarah Jenkins (Receptionist)',
                'email' => 'receptionist@example.com',
                'password' => $defaultPassword,
                'role' => 'receptionist',
                'phone' => '+1 (555) 100-0005',
                'status' => 'active',
            ],
            [
                'name' => 'David Lee (Chief Pharmacist)',
                'email' => 'pharmacist@example.com',
                'password' => $defaultPassword,
                'role' => 'pharmacist',
                'phone' => '+1 (555) 100-0006',
                'status' => 'active',
            ],
            [
                'name' => 'Laura Palmer (Billing & Accounts)',
                'email' => 'accountant@example.com',
                'password' => $defaultPassword,
                'role' => 'accountant',
                'phone' => '+1 (555) 100-0007',
                'status' => 'active',
            ],
            [
                'name' => 'Johnathan Miller (Patient)',
                'email' => 'patient@example.com',
                'password' => $defaultPassword,
                'role' => 'patient',
                'phone' => '+1 (555) 100-0008',
                'status' => 'active',
            ],
        ];

        foreach ($users as $u) {
            User::create($u);
        }

        // 3. Departments
        $cardiology = Department::create([
            'name' => 'Cardiology',
            'description' => 'Comprehensive cardiovascular diagnosis, intervention, and telemetry monitoring.',
            'status' => 'active',
        ]);
        $neurology = Department::create([
            'name' => 'Neurology',
            'description' => 'Specialized brain, spinal cord, and peripheral nervous system care.',
            'status' => 'active',
        ]);
        $pediatrics = Department::create([
            'name' => 'Pediatrics',
            'description' => 'Infant, child, and adolescent medical care and vaccinations.',
            'status' => 'active',
        ]);
        $orthopedics = Department::create([
            'name' => 'Orthopedics',
            'description' => 'Musculoskeletal trauma, joint reconstruction, and sports medicine.',
            'status' => 'active',
        ]);
        $generalSurgery = Department::create([
            'name' => 'General Surgery & Trauma',
            'description' => 'Elective and acute surgical interventions and emergency trauma.',
            'status' => 'active',
        ]);

        // 4. Doctors
        $doc1 = Doctor::create([
            'doctor_id' => 'DOC-0001',
            'user_id' => 3, // Dr. Gregory House
            'department_id' => $cardiology->id,
            'name' => 'Dr. Gregory House',
            'email' => 'doctor@example.com',
            'phone' => '+1 (555) 234-5678',
            'specialization' => 'Senior Interventional Cardiologist',
            'qualification' => 'MD, FACC, Harvard Medical',
            'consultation_fee' => 120.00,
            'address' => 'Suite 401, Medical Tower West',
            'status' => 'active',
        ]);

        $doc2 = Doctor::create([
            'doctor_id' => 'DOC-0002',
            'department_id' => $neurology->id,
            'name' => 'Dr. Meredith Grey',
            'email' => 'mgrey@carepoint.org',
            'phone' => '+1 (555) 345-6789',
            'specialization' => 'Neurosurgeon',
            'qualification' => 'MD, FACS, Johns Hopkins',
            'consultation_fee' => 150.00,
            'address' => 'Suite 302, Surgical Wing',
            'status' => 'active',
        ]);

        $doc3 = Doctor::create([
            'doctor_id' => 'DOC-0003',
            'department_id' => $pediatrics->id,
            'name' => 'Dr. Robert Chase',
            'email' => 'rchase@carepoint.org',
            'phone' => '+1 (555) 456-7890',
            'specialization' => 'Pediatric Intensivist',
            'qualification' => 'MBBS, FAAP, Oxford University',
            'consultation_fee' => 95.00,
            'address' => 'Suite 104, Children’s Pavilion',
            'status' => 'active',
        ]);

        // 5. Nurses
        Nurse::create([
            'nurse_id' => 'NUR-0001',
            'user_id' => 4,
            'department_id' => $cardiology->id,
            'name' => 'Nurse Clara Barton',
            'email' => 'nurse@example.com',
            'phone' => '+1 (555) 100-0004',
            'qualification' => 'BSN, RN, CCRN',
            'status' => 'active',
        ]);
        Nurse::create([
            'nurse_id' => 'NUR-0002',
            'department_id' => $neurology->id,
            'name' => 'Nurse Florence Night',
            'email' => 'fnight@carepoint.org',
            'phone' => '+1 (555) 567-8901',
            'qualification' => 'MSN, RN, CNRN',
            'status' => 'active',
        ]);

        // 6. Staff
        Staff::create([
            'staff_id' => 'STF-0001',
            'name' => 'Sarah Jenkins',
            'department_id' => $cardiology->id,
            'designation' => 'Front Desk Receptionist',
            'phone' => '+1 (555) 100-0005',
            'email' => 'receptionist@example.com',
            'salary' => 3800.00,
            'status' => 'active',
        ]);
        Staff::create([
            'staff_id' => 'STF-0002',
            'name' => 'Thomas Henderson',
            'department_id' => $generalSurgery->id,
            'designation' => 'Biomedical Facility Technician',
            'phone' => '+1 (555) 678-9012',
            'email' => 'thenderson@carepoint.org',
            'salary' => 4600.00,
            'status' => 'active',
        ]);

        // 7. Rooms & Beds
        $room101 = Room::create([
            'room_number' => '101',
            'room_type' => 'Private',
            'department_id' => $cardiology->id,
            'floor' => 1,
            'status' => 'occupied',
            'description' => 'Deluxe private room with continuous cardiac monitoring.',
        ]);
        $room102 = Room::create([
            'room_number' => '102',
            'room_type' => 'Semi-Private',
            'department_id' => $cardiology->id,
            'floor' => 1,
            'status' => 'available',
            'description' => 'Twin occupancy ward with bedside telemetry.',
        ]);
        $roomICU = Room::create([
            'room_number' => 'ICU-1',
            'room_type' => 'ICU',
            'department_id' => $generalSurgery->id,
            'floor' => 2,
            'status' => 'available',
            'description' => 'Level 1 Intensive Care Unit with ventilators.',
        ]);

        $bed1A = Bed::create(['bed_number' => '101-A', 'room_id' => $room101->id, 'status' => 'Occupied']);
        $bed2A = Bed::create(['bed_number' => '102-A', 'room_id' => $room102->id, 'status' => 'Available']);
        $bed2B = Bed::create(['bed_number' => '102-B', 'room_id' => $room102->id, 'status' => 'Available']);
        $bedICU1 = Bed::create(['bed_number' => 'ICU-B1', 'room_id' => $roomICU->id, 'status' => 'Available']);

        // 8. Patients
        $pat1 = Patient::create([
            'patient_id' => 'PAT-00001',
            'user_id' => 8,
            'name' => 'Johnathan Miller',
            'email' => 'patient@example.com',
            'phone' => '+1 (555) 987-6543',
            'gender' => 'Male',
            'date_of_birth' => '1985-06-15',
            'blood_group' => 'O+',
            'address' => '42 Elm Street, Springfield',
            'emergency_contact' => 'Mary Miller (Wife)',
            'emergency_phone' => '+1 (555) 987-6544',
            'status' => 'active',
        ]);

        $pat2 = Patient::create([
            'patient_id' => 'PAT-00002',
            'name' => 'Emily Catherine Watson',
            'email' => 'emily.watson@gmail.com',
            'phone' => '+1 (555) 876-5432',
            'gender' => 'Female',
            'date_of_birth' => '1992-11-23',
            'blood_group' => 'A+',
            'address' => '120 Magnolia Blvd, Springfield',
            'emergency_contact' => 'Arthur Watson (Father)',
            'emergency_phone' => '+1 (555) 876-5433',
            'status' => 'active',
        ]);

        $pat3 = Patient::create([
            'patient_id' => 'PAT-00003',
            'name' => 'Lucas Avery Sanchez',
            'email' => 'lucas.sanchez@yahoo.com',
            'phone' => '+1 (555) 765-4321',
            'gender' => 'Male',
            'date_of_birth' => '2016-04-10',
            'blood_group' => 'B+',
            'address' => '88 Pine Ridge, Springfield',
            'emergency_contact' => 'Elena Sanchez (Mother)',
            'emergency_phone' => '+1 (555) 765-4322',
            'status' => 'active',
        ]);

        // 9. Pharmacy & Medicines
        $med1 = Medicine::create([
            'name' => 'Amoxil 500mg',
            'generic_name' => 'Amoxicillin Trihydrate',
            'category' => 'Antibiotics',
            'description' => 'Broad-spectrum beta-lactam antibiotic for bacterial infections.',
            'price' => 14.50,
            'stock_quantity' => 150,
            'expiry_date' => Carbon::now()->addMonths(18),
        ]);

        $med2 = Medicine::create([
            'name' => 'Lipitor 20mg',
            'generic_name' => 'Atorvastatin Calcium',
            'category' => 'Cardiovascular',
            'description' => 'HMG-CoA reductase inhibitor for lowering lipid and cholesterol levels.',
            'price' => 28.00,
            'stock_quantity' => 85,
            'expiry_date' => Carbon::now()->addMonths(24),
        ]);

        $med3 = Medicine::create([
            'name' => 'Metformin HCl 850mg',
            'generic_name' => 'Metformin Hydrochloride',
            'category' => 'Antidiabetic',
            'description' => 'First-line medication for the treatment of type 2 diabetes mellitus.',
            'price' => 9.75,
            'stock_quantity' => 12, // LOW STOCK TRIGGER (< 20)
            'expiry_date' => Carbon::now()->addMonths(12),
        ]);

        $med4 = Medicine::create([
            'name' => 'Ventolin Inhaler',
            'generic_name' => 'Albuterol Sulfate',
            'category' => 'Respiratory',
            'description' => 'Rapid bronchodilator for acute asthma exacerbations.',
            'price' => 35.00,
            'stock_quantity' => 8, // LOW STOCK TRIGGER (< 20)
            'expiry_date' => Carbon::now()->addMonths(6),
        ]);

        // 10. Appointments
        Appointment::create([
            'appointment_id' => 'APP-00001',
            'patient_id' => $pat1->id,
            'doctor_id' => $doc1->id,
            'department_id' => $cardiology->id,
            'appointment_date' => Carbon::today(),
            'appointment_time' => '10:30:00',
            'status' => 'Confirmed',
            'reason' => 'Quarterly hypertension and telemetry checkup.',
            'notes' => 'Patient has maintained stable BP 124/82.',
        ]);

        Appointment::create([
            'appointment_id' => 'APP-00002',
            'patient_id' => $pat2->id,
            'doctor_id' => $doc2->id,
            'department_id' => $neurology->id,
            'appointment_date' => Carbon::today(),
            'appointment_time' => '14:00:00',
            'status' => 'Pending',
            'reason' => 'Persistent migraine headache and visual aura.',
            'notes' => 'Pending MRI brain contrast schedule.',
        ]);

        Appointment::create([
            'appointment_id' => 'APP-00003',
            'patient_id' => $pat3->id,
            'doctor_id' => $doc3->id,
            'department_id' => $pediatrics->id,
            'appointment_date' => Carbon::tomorrow(),
            'appointment_time' => '11:00:00',
            'status' => 'Confirmed',
            'reason' => 'Annual pediatric developmental wellness examination.',
            'notes' => 'Immunizations up to date.',
        ]);

        // 11. Clinical Medical Records
        MedicalRecord::create([
            'patient_id' => $pat1->id,
            'doctor_id' => $doc1->id,
            'record_date' => Carbon::now()->subDays(5),
            'symptoms' => 'Mild palpitations after moderate exertion, occasional dizziness.',
            'diagnosis' => 'Stage 1 Essential Hypertension with sinus tachycardia.',
            'treatment' => 'Dietary sodium reduction, daily cardio exercise, initiate Statin + ACE inhibitor therapy.',
            'notes' => 'Re-evaluate in 30 days with comprehensive metabolic panel.',
        ]);

        // 12. Prescriptions
        $rx1 = Prescription::create([
            'prescription_id' => 'RX-00001',
            'patient_id' => $pat1->id,
            'doctor_id' => $doc1->id,
            'prescription_date' => Carbon::now()->subDays(5),
            'instructions' => 'Take Atorvastatin at bedtime. Take Amoxicillin with meals. Avoid grapefruit juice.',
        ]);

        PrescriptionItem::create([
            'prescription_id' => $rx1->id,
            'medicine_id' => $med2->id,
            'dosage' => '20mg',
            'frequency' => 'Once daily at bedtime (0-0-1)',
            'duration' => '30 days',
        ]);
        PrescriptionItem::create([
            'prescription_id' => $rx1->id,
            'medicine_id' => $med1->id,
            'dosage' => '500mg',
            'frequency' => 'Twice daily after meals (1-0-1)',
            'duration' => '7 days',
        ]);

        // 13. Admissions
        $adm1 = Admission::create([
            'admission_id' => 'ADM-00001',
            'patient_id' => $pat1->id,
            'doctor_id' => $doc1->id,
            'room_id' => $room101->id,
            'bed_id' => $bed1A->id,
            'admission_date' => Carbon::now()->subDays(2),
            'reason' => 'Acute cardiac telemetry observation for intermittent arrhythmias.',
            'diagnosis' => 'Supraventricular Tachycardia (SVT) under monitoring',
            'status' => 'Admitted',
            'notes' => 'Placed on continuous wireless ECG monitor in Room 101.',
        ]);

        // 14. Invoices & Billing
        $inv1 = Invoice::create([
            'invoice_number' => 'INV-00001',
            'patient_id' => $pat1->id,
            'admission_id' => $adm1->id,
            'invoice_date' => Carbon::now()->subDays(1),
            'subtotal' => 450.00,
            'discount' => 25.00,
            'tax' => 21.25,
            'total' => 446.25,
            'status' => 'Partial',
        ]);

        InvoiceItem::create([
            'invoice_id' => $inv1->id,
            'description' => 'Senior Cardiologist Specialist Consultation',
            'quantity' => 1,
            'unit_price' => 120.00,
            'total' => 120.00,
        ]);
        InvoiceItem::create([
            'invoice_id' => $inv1->id,
            'description' => 'Private Ward Room Daily Rate (Room 101)',
            'quantity' => 2,
            'unit_price' => 150.00,
            'total' => 300.00,
        ]);
        InvoiceItem::create([
            'invoice_id' => $inv1->id,
            'description' => '12-Lead Electrocardiogram (ECG)',
            'quantity' => 1,
            'unit_price' => 30.00,
            'total' => 30.00,
        ]);

        // 15. Payments
        Payment::create([
            'payment_id' => 'PAY-00001',
            'invoice_id' => $inv1->id,
            'patient_id' => $pat1->id,
            'amount' => 200.00,
            'payment_method' => 'Credit Card',
            'payment_date' => Carbon::today(),
            'reference' => 'TXN-VISA-982347',
            'status' => 'Success',
        ]);
    }
}
