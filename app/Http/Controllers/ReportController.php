<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function patients(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $patients = $query->latest()->get();
        return view('reports.patients', compact('patients'));
    }

    public function doctors(Request $request)
    {
        $query = Doctor::with('department');

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $doctors = $query->get();
        $departments = Department::all();
        return view('reports.doctors', compact('doctors', 'departments'));
    }

    public function appointments(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'department']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('appointment_date', [$request->start_date, $request->end_date]);
        }

        $appointments = $query->latest('appointment_date')->get();
        $doctors = Doctor::all();
        return view('reports.appointments', compact('appointments', 'doctors'));
    }

    public function admissions(Request $request)
    {
        $query = Admission::with(['patient', 'doctor', 'room', 'bed']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('admission_date', [$request->start_date, $request->end_date]);
        }

        $admissions = $query->latest('admission_date')->get();
        return view('reports.admissions', compact('admissions'));
    }

    public function billing(Request $request)
    {
        $query = Invoice::with(['patient', 'payments']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('invoice_date', [$request->start_date, $request->end_date]);
        }

        $invoices = $query->latest('invoice_date')->get();
        $totalBilled = $invoices->sum('total');
        return view('reports.billing', compact('invoices', 'totalBilled'));
    }

    public function payments(Request $request)
    {
        $query = Payment::with(['invoice', 'patient']);

        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('payment_date', [$request->start_date, $request->end_date]);
        }

        $payments = $query->latest('payment_date')->get();
        $totalCollected = $payments->sum('amount');
        return view('reports.payments', compact('payments', 'totalCollected'));
    }

    public function medicines(Request $request)
    {
        $query = Medicine::query();

        if ($request->input('stock') === 'low') {
            $query->where('stock_quantity', '<=', 20);
        }

        $medicines = $query->orderBy('stock_quantity')->get();
        return view('reports.medicines', compact('medicines'));
    }
}
