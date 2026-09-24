<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdmissionRequest;
use App\Models\Admission;
use App\Models\Bed;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Admission::with(['patient', 'doctor', 'room', 'bed']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('patient_id', 'like', "%{$search}%");
            });
        }

        $admissions = $query->latest('admission_date')->paginate(15)->withQueryString();

        return view('admissions.index', compact('admissions'));
    }

    public function create()
    {
        $patients = Patient::where('status', 'active')->get();
        $doctors = Doctor::where('status', 'active')->get();
        $rooms = Room::with('beds')->where('status', '!=', 'maintenance')->get();
        $availableBeds = Bed::where('status', 'Available')->with('room')->get();

        return view('admissions.create', compact('patients', 'doctors', 'rooms', 'availableBeds'));
    }

    public function store(StoreAdmissionRequest $request)
    {
        $bed = Bed::findOrFail($request->bed_id);
        if ($bed->status !== 'Available') {
            return back()->withErrors(['bed_id' => 'The selected bed is currently occupied or under maintenance.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $lastAdm = Admission::latest('id')->first();
            $nextNum = $lastAdm ? ($lastAdm->id + 1) : 1;
            $admissionId = 'ADM-' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);

            $admission = Admission::create(array_merge(
                $request->validated(),
                [
                    'admission_id' => $admissionId,
                    'status' => 'Admitted'
                ]
            ));

            $bed->update(['status' => 'Occupied']);

            DB::commit();

            return redirect()->route('admissions.show', $admission)
                ->with('success', "Patient successfully admitted to Room {$bed->room->room_number}, Bed {$bed->bed_number}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Admission failed: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Admission $admission)
    {
        $admission->load(['patient', 'doctor.department', 'room', 'bed', 'discharge']);
        return view('admissions.show', compact('admission'));
    }

    public function edit(Admission $admission)
    {
        $doctors = Doctor::where('status', 'active')->get();
        $rooms = Room::all();
        $beds = Bed::where('room_id', $admission->room_id)->get();

        return view('admissions.edit', compact('admission', 'doctors', 'rooms', 'beds'));
    }

    public function update(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'reason' => 'required|string',
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:Admitted,Discharged,Transferred',
        ]);

        $admission->update($validated);

        return redirect()->route('admissions.show', $admission)
            ->with('success', "Admission record updated.");
    }
}
