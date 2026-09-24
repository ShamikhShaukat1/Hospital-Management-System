<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::with('department');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('staff_id', 'like', "%{$search}%");
            });
        }

        $staff = $query->paginate(15)->withQueryString();

        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $departments = Department::where('status', 'active')->get();
        return view('staff.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:staff,email',
            'salary' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $lastStaff = Staff::latest('id')->first();
        $nextNum = $lastStaff ? ($lastStaff->id + 1) : 1;
        $staffId = 'STF-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        $member = Staff::create(array_merge($validated, ['staff_id' => $staffId]));

        return redirect()->route('staff.show', $member)
            ->with('success', "Staff member {$member->name} added successfully.");
    }

    public function show(Staff $staff)
    {
        $staff->load('department');
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $departments = Department::where('status', 'active')->get();
        return view('staff.edit', compact('staff', 'departments'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'salary' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $staff->update($validated);

        return redirect()->route('staff.show', $staff)
            ->with('success', "Staff details updated.");
    }

    public function delete(Staff $staff)
    {
        return view('staff.delete', compact('staff'));
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', "Staff record deleted.");
    }
}
