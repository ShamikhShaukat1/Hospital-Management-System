<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Bed;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class BedController extends Controller
{
    public function index(Request $request)
    {
        $query = Bed::with(['room.department']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        $beds = $query->paginate(20)->withQueryString();
        $rooms = Room::all();

        return view('beds.index', compact('beds', 'rooms'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('beds.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bed_number' => 'required|string',
            'room_id'    => 'required|exists:rooms,id',
            'status'     => 'required|in:Available,Occupied,Maintenance,Reserved',
        ]);

        $bed = Bed::create($validated);
        $bed->load('room');
        $usersToNotify = $this->getStaffRecipients();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'New Bed Added',
            message: "Bed {$bed->bed_number} was added to Room {$bed->room->room_number} with status '{$bed->status}'.",
            url: route('beds.index', ['room_id' => $bed->room_id]),
            type: 'bed_created',
            icon: 'fa-bed',
            color: 'teal'
        );

        return redirect()->route('beds.index')->with('success', "Bed {$bed->bed_number} added to room.");
    }

    public function edit(Bed $bed)
    {
        $rooms = Room::all();
        return view('beds.edit', compact('bed', 'rooms'));
    }

    public function update(Request $request, Bed $bed)
    {
        $validated = $request->validate([
            'bed_number' => 'required|string',
            'room_id'    => 'required|exists:rooms,id',
            'status'     => 'required|in:Available,Occupied,Maintenance,Reserved',
        ]);

        $oldStatus = $bed->status;
        $bed->update($validated);
        $bed->load('room');

        $statusNotice = ($oldStatus !== $bed->status) ? " Status changed from {$oldStatus} to {$bed->status}." : "";
        $usersToNotify = $this->getStaffRecipients();

        $icon = match ($bed->status) {
            'Maintenance' => 'fa-triangle-exclamation',
            'Occupied'    => 'fa-bed-pulse',
            'Reserved'    => 'fa-clock',
            default       => 'fa-bed',
        };

        $color = match ($bed->status) {
            'Maintenance' => 'amber',
            'Occupied'    => 'blue',
            'Reserved'    => 'purple',
            default       => 'emerald',
        };

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Bed Details Updated',
            message: "Bed {$bed->bed_number} in Room {$bed->room->room_number} was updated.{$statusNotice}",
            url: route('beds.index', ['room_id' => $bed->room_id]),
            type: 'bed_updated',
            icon: $icon,
            color: $color
        );

        return redirect()->route('beds.index')->with('success', "Bed {$bed->bed_number} updated.");
    }

    public function delete(Bed $bed)
    {
        return view('beds.delete', compact('bed'));
    }

    public function destroy(Bed $bed)
    {
        $bed->load('room');
        $bedNumber = $bed->bed_number;
        $roomNumber = $bed->room->room_number ?? 'N/A';
        $usersToNotify = $this->getStaffRecipients();

        $bed->delete();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Bed Removed',
            message: "Bed {$bedNumber} in Room {$roomNumber} was removed from facility management.",
            url: route('beds.index'),
            type: 'bed_deleted',
            icon: 'fa-trash-can',
            color: 'rose'
        );

        return redirect()->route('beds.index')->with('success', "Bed deleted.");
    }

    private function getStaffRecipients()
    {
        return User::whereIn('role', ['super_admin', 'admin', 'doctor', 'nurse'])->get();
    }
}
