<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::withCount(['doctors', 'nurses', 'staff', 'rooms']);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
        }

        $departments = $query->paginate(15)->withQueryString();

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $department = Department::create($validated);

        return redirect()->route('departments.show', $department)
            ->with('success', "Department {$department->name} created successfully.");
    }

    public function show(Department $department)
    {
        $department->load(['doctors', 'nurses', 'staff', 'rooms.beds']);

        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $department->update($validated);

        return redirect()->route('departments.show', $department)
            ->with('success', "Department {$department->name} updated successfully.");
    }

    public function delete(Department $department)
    {
        return view('departments.delete', compact('department'));
    }

    public function destroy(Department $department)
    {
        $name = $department->name;
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', "Department {$name} deleted successfully.");
    }
}
