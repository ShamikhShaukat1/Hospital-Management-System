<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Department;
use App\Models\User;
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

        $departments = $query->paginate(10)->withQueryString();

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
        $usersToNotify = $this->getDepartmentRecipients($department);

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'New Department Created',
            message: "Department '{$department->name}' has been created successfully.",
            url: route('departments.show', $department->id),
            type: 'department_created',
            icon: 'fa-sitemap',
            color: 'teal'
        );

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

        $usersToNotify = $this->getDepartmentRecipients($department);

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Department Details Updated',
            message: "Department '{$department->name}' has been updated.",
            url: route('departments.show', $department->id),
            type: 'department_updated',
            icon: 'fa-pen-to-square',
            color: 'blue'
        );

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
        $usersToNotify = $this->getDepartmentRecipients($department);
        $department->delete();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Department Deleted',
            message: "Department '{$name}' has been deleted.",
            url: route('departments.index'),
            type: 'department_deleted',
            icon: 'fa-trash-can',
            color: 'rose'
        );

        return redirect()->route('departments.index')
            ->with('success', "Department {$name} deleted successfully.");
    }

    private function getDepartmentRecipients(Department $department)
    {
        return User::whereIn('role', ['super_admin', 'admin', 'hr', 'staff'])->get();
    }
}
