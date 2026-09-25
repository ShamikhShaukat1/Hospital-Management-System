<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
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

        $staff = $query->paginate(10)->withQueryString();

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
        $member->load(['department', 'user']);

        $usersToNotify = $this->getStaffRecipients($member);

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'New Staff Member Added',
            message: "Staff member {$member->name} ({$member->staff_id}) has been registered as {$member->designation}.",
            url: route('staff.show', $member->id),
            type: 'staff_created',
            icon: 'fa-id-card',
            color: 'teal'
        );

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
        $staff->load(['department', 'user']);
        $usersToNotify = $this->getStaffRecipients($staff);

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Staff Profile Updated',
            message: "Details for staff member {$staff->name} ({$staff->staff_id}) have been updated.",
            url: route('staff.show', $staff->id),
            type: 'staff_updated',
            icon: 'fa-user-gear',
            color: 'blue'
        );

        return redirect()->route('staff.show', $staff)
            ->with('success', "Staff details updated.");
    }

    public function delete(Staff $staff)
    {
        return view('staff.delete', compact('staff'));
    }

    public function destroy(Staff $staff)
    {
        $staff->load(['department', 'user']);

        $staffName = $staff->name;
        $staffId = $staff->staff_id;
        $usersToNotify = $this->getStaffRecipients($staff);

        $staff->delete();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Staff Record Removed',
            message: "Staff record for {$staffName} ({$staffId}) was deleted.",
            url: route('staff.index'),
            type: 'staff_deleted',
            icon: 'fa-user-minus',
            color: 'rose'
        );

        return redirect()->route('staff.index')->with('success', "Staff record deleted.");
    }

    private function getStaffRecipients(Staff $staff)
    {
        $users = collect();
        $management = User::whereIn('role', ['super_admin', 'admin', 'hr'])->get();
        $users = $users->merge($management);

        if ($staff->user) {
            $users->push($staff->user);
        }

        return $users->unique('id');
    }
}
