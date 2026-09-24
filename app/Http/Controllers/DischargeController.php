<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDischargeRequest;
use App\Models\Admission;
use App\Models\Discharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DischargeController extends Controller
{
    public function index(Request $request)
    {
        $query = Discharge::with(['admission', 'patient', 'doctor']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', function ($patientQuery) use ($search) {
                    $patientQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('patient_id', 'like', "%{$search}%");
                })->orWhere('discharge_id', 'like', "%{$search}%");
            });
        }

        $discharges = $query->latest('discharge_date')->paginate(15)->withQueryString();

        return view('discharges.index', compact('discharges'));
    }

    public function create(Request $request)
    {
        $admissionId = $request->input('admission_id');
        $admission = Admission::with(['patient', 'doctor', 'room', 'bed'])->findOrFail($admissionId);

        if ($admission->status !== 'Admitted') {
            return redirect()->route('admissions.show', $admission)
                ->withErrors(['admission' => 'This patient has already been discharged or transferred.']);
        }

        return view('discharges.create', compact('admission'));
    }

    public function store(StoreDischargeRequest $request)
    {
        DB::beginTransaction();
        try {
            // Lock record to prevent concurrent discharge submissions
            $admission = Admission::where('id', $request->admission_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($admission->status !== 'Admitted') {
                DB::rollBack();
                return redirect()->route('admissions.show', $admission)
                    ->withErrors(['admission' => 'This patient has already been discharged or transferred.']);
            }

            // Create record with placeholder ID to prevent sequence collision
            $discharge = Discharge::create([
                'discharge_id' => 'DIS-TEMP',
                'admission_id' => $admission->id,
                'patient_id' => $admission->patient_id,
                'doctor_id' => $admission->doctor_id,
                'discharge_date' => $request->discharge_date,
                'discharge_time' => $request->discharge_time,
                'diagnosis' => $request->diagnosis,
                'treatment_summary' => $request->treatment_summary,
                'instructions' => $request->instructions,
                'status' => 'Finalized',
            ]);

            // Assign unique padded ID based on primary key
            $dischargeId = 'DIS-' . str_pad($discharge->id, 5, '0', STR_PAD_LEFT);
            $discharge->update(['discharge_id' => $dischargeId]);

            // Update admission status
            $admission->update(['status' => 'Discharged']);

            // Free the bed if assigned
            $bedNumber = 'N/A';
            if ($admission->bed) {
                $admission->bed->update(['status' => 'Available']);
                $bedNumber = $admission->bed->bed_number;
            }

            DB::commit();

            return redirect()->route('discharges.show', $discharge)
                ->with('success', "Patient successfully discharged. Bed {$bedNumber} is now marked Available.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Discharge failed: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Discharge $discharge)
    {
        $discharge->load(['admission.room', 'admission.bed', 'patient', 'doctor.department']);
        return view('discharges.show', compact('discharge'));
    }
}
