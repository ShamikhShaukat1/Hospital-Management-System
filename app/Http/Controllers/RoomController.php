<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Room;
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
            'room_number' => 'required|string|unique:rooms,room_number',
            'room_type' => 'required|in:General Ward,Semi-Private,Private,ICU,Emergency,Operation Theatre',
            'department_id' => 'nullable|exists:departments,id',
            'floor' => 'required|integer|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string',
        ]);

        $room = Room::create($validated);

        return redirect()->route('rooms.show', $room)
            ->with('success', "Room {$room->room_number} created successfully.");
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
            'room_number' => 'required|string|unique:rooms,room_number,' . $room->id,
            'room_type' => 'required|in:General Ward,Semi-Private,Private,ICU,Emergency,Operation Theatre',
            'department_id' => 'nullable|exists:departments,id',
            'floor' => 'required|integer|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.show', $room)
            ->with('success', "Room {$room->room_number} updated.");
    }

    public function delete(Room $room)
    {
        return view('rooms.delete', compact('room'));
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', "Room removed.");
    }
}
