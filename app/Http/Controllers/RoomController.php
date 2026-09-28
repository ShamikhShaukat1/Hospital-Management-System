<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Department;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with(['department', 'beds']);

        if ($request->filled('type')) {
            $query->where('room_type', $request->type);
        }

        if ($request->filled('floor')) {
            $query->where('floor', $request->floor);
        }

        $rooms = $query->paginate(15)->withQueryString();

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $departments = Department::where('status', 'active')->get();
        return view('rooms.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number'   => 'required|string|unique:rooms,room_number',
            'room_type'     => 'required|in:General Ward,Semi-Private,Private,ICU,Emergency,Operation Theatre',
            'department_id' => 'nullable|exists:departments,id',
            'floor'         => 'required|integer|min:0',
            'status'        => 'required|in:available,occupied,maintenance',
            'description'   => 'nullable|string',
        ]);

        $room = Room::create($validated);
        $usersToNotify = $this->getStaffRecipients();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'New Room Added',
            message: "Room {$room->room_number} ({$room->room_type}) on Floor {$room->floor} was added to facility management.",
            url: route('rooms.show', $room->id),
            type: 'room_created',
            icon: 'fa-door-open',
            color: 'teal'
        );

        return redirect()->route('rooms.show', $room)->with('success', "Room {$room->room_number} created successfully.");
    }

    public function show(Room $room)
    {
        $room->load(['department', 'beds.admissions.patient']);
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $departments = Department::where('status', 'active')->get();
        return view('rooms.edit', compact('room', 'departments'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number'   => 'required|string|unique:rooms,room_number,' . $room->id,
            'room_type'     => 'required|in:General Ward,Semi-Private,Private,ICU,Emergency,Operation Theatre',
            'department_id' => 'nullable|exists:departments,id',
            'floor'         => 'required|integer|min:0',
            'status'        => 'required|in:available,occupied,maintenance',
            'description'   => 'nullable|string',
        ]);

        $oldStatus = $room->status;
        $room->update($validated);
        $statusNotice = ($oldStatus !== $room->status) ? " Status changed from " . ucfirst($oldStatus) . " to " . ucfirst($room->status) . "." : "";
        $usersToNotify = $this->getStaffRecipients();

        $icon = $room->status === 'maintenance' ? 'fa-triangle-exclamation' : 'fa-door-closed';
        $color = $room->status === 'maintenance' ? 'amber' : 'blue';

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Room Details Updated',
            message: "Room {$room->room_number} details have been updated.{$statusNotice}",
            url: route('rooms.show', $room->id),
            type: 'room_updated',
            icon: $icon,
            color: $color
        );

        return redirect()->route('rooms.show', $room)->with('success', "Room {$room->room_number} updated.");
    }

    public function delete(Room $room)
    {
        return view('rooms.delete', compact('room'));
    }

    public function destroy(Room $room)
    {
        $roomNumber = $room->room_number;
        $roomType = $room->room_type;
        $usersToNotify = $this->getStaffRecipients();

        $room->delete();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Room Removed',
            message: "Room {$roomNumber} ({$roomType}) was removed from facility management.",
            url: route('rooms.index'),
            type: 'room_deleted',
            icon: 'fa-trash-can',
            color: 'rose'
        );

        return redirect()->route('rooms.index')->with('success', "Room removed.");
    }

    private function getStaffRecipients()
    {
        return User::whereIn('role', ['super_admin', 'admin', 'doctor', 'nurse'])->get();
    }
}
