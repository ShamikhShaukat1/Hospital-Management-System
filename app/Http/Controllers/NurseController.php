<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Department;
use App\Models\Nurse;
use App\Models\User;
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

        $nurses = $query->paginate(10)->withQueryString();

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
        $nurse->load(['department', 'user']);

        $usersToNotify = $this->getNurseRecipients($nurse);

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'New Nurse Registered',
            message: "Nurse {$nurse->name} ({$nurse->nurse_id}) has been registered.",
            url: route('nurses.show', $nurse->id),
            type: 'nurse_created',
            icon: 'fa-user-nurse',
            color: 'teal'
        );

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
        $nurse->load(['department', 'user']);

        $usersToNotify = $this->getNurseRecipients($nurse);

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Nurse Profile Updated',
            message: "Details for Nurse {$nurse->name} ({$nurse->nurse_id}) have been updated.",
            url: route('nurses.show', $nurse->id),
            type: 'nurse_updated',
            icon: 'fa-user-pen',
            color: 'blue'
        );

        return redirect()->route('nurses.show', $nurse)
            ->with('success', "Nurse details updated successfully.");
    }

    public function delete(Nurse $nurse)
    {
        return view('nurses.delete', compact('nurse'));
    }

    public function destroy(Nurse $nurse)
    {
        $nurse->load(['department', 'user']);

        $nurseName = $nurse->name;
        $nurseId = $nurse->nurse_id;
        $usersToNotify = $this->getNurseRecipients($nurse);

        $nurse->delete();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Nurse Record Removed',
            message: "Nurse record for {$nurseName} ({$nurseId}) was deleted.",
            url: route('nurses.index'),
            type: 'nurse_deleted',
            icon: 'fa-user-slash',
            color: 'rose'
        );

        return redirect()->route('nurses.index')->with('success', "Nurse record deleted.");
    }

    private function getNurseRecipients(Nurse $nurse)
    {
        $users = collect();
        $staffUsers = User::whereIn('role', ['super_admin', 'admin', 'hr', 'staff'])->get();
        $users = $users->merge($staffUsers);

        if ($nurse->user) {
            $users->push($nurse->user);
        }

        return $users->unique('id');
    }
}
