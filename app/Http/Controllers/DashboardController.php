<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Bed;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Medicine;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $user = Auth::user();

        // High-level statistics
        $stats = [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'total_nurses' => Nurse::count(),
            'total_staff' => Staff::count(),
            'today_appointments' => Appointment::whereDate('appointment_date', $today)->count(),
            'pending_appointments' => Appointment::where('status', 'Pending')->count(),
            'current_admissions' => Admission::where('status', 'Admitted')->count(),
            'available_beds' => Bed::where('status', 'Available')->count(),
            'total_beds' => Bed::count(),
            'total_medicines' => Medicine::count(),
            'low_stock_medicines' => Medicine::where('stock_quantity', '<=', 20)->count(),
            'pending_bills' => Invoice::where('status', 'Unpaid')->count(),
            'today_payments' => (float) Payment::whereDate('payment_date', $today)->where('status', 'Success')->sum('amount'),
            'total_revenue' => (float) Payment::where('status', 'Success')->sum('amount'),
        ];

        // Role-tailored recent activities
        $todayAppointments = Appointment::with(['patient', 'doctor', 'department'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time')
            ->take(6)
            ->get();

        $recentAdmissions = Admission::with(['patient', 'doctor', 'room', 'bed'])
            ->where('status', 'Admitted')
            ->latest()
            ->take(5)
            ->get();

        $lowStockList = Medicine::where('stock_quantity', '<=', 20)
            ->orderBy('stock_quantity')
            ->take(5)
            ->get();

        $recentInvoices = Invoice::with('patient')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'stats',
            'todayAppointments',
            'recentAdmissions',
            'lowStockList',
            'recentInvoices',
            'user'
        ));
    }
}
