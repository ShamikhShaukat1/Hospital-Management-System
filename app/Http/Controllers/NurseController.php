<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Nurse;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function index(Request $request)
    {
        $query = Nurse::with('department');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nurse_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $nurses = $query->paginate(15)->withQueryString();

        return view('nurses.index', compact('nurses'));
    }

    public function create()
    {
        $departments = Department::where('status', 'active')->get();
        return view('nurses.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'qualification' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:nurses,email',
            'status' => 'required|in:active,inactive',
        ]);

        $lastNurse = Nurse::latest('id')->first();
        $nextNum = $lastNurse ? ($lastNurse->id + 1) : 1;
        $nurseId = 'NUR-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        $nurse = Nurse::create(array_merge($validated, ['nurse_id' => $nurseId]));

        return redirect()->route('nurses.show', $nurse)
            ->with('success', "Nurse {$nurse->name} registered successfully.");
    }

    public function show(Nurse $nurse)
    {
        $nurse->load('department');
        return view('nurses.show', compact('nurse'));
    }

    public function edit(Nurse $nurse)
    {
        $departments = Department::where('status', 'active')->get();
        return view('nurses.edit', compact('nurse', 'departments'));
    }

    public function update(Request $request, Nurse $nurse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'qualification' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:nurses,email,' . $nurse->id,
            'status' => 'required|in:active,inactive',
        ]);

        $nurse->update($validated);

        return redirect()->route('nurses.show', $nurse)
            ->with('success', "Nurse details updated successfully.");
    }

    public function delete(Nurse $nurse)
    {
        return view('nurses.delete', compact('nurse'));
    }

    public function destroy(Nurse $nurse)
    {
        $nurse->delete();
        return redirect()->route('nurses.index')->with('success', "Nurse record deleted.");
    }
}
