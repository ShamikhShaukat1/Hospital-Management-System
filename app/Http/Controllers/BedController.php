<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Room;
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
            'room_id' => 'required|exists:rooms,id',
            'status' => 'required|in:Available,Occupied,Maintenance,Reserved',
        ]);

        $bed = Bed::create($validated);

        return redirect()->route('beds.index')
            ->with('success', "Bed {$bed->bed_number} added to room.");
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
            'room_id' => 'required|exists:rooms,id',
            'status' => 'required|in:Available,Occupied,Maintenance,Reserved',
        ]);

        $bed->update($validated);

        return redirect()->route('beds.index')
            ->with('success', "Bed {$bed->bed_number} updated.");
    }

    public function delete(Bed $bed)
    {
        return view('beds.delete', compact('bed'));
    }

    public function destroy(Bed $bed)
    {
        $bed->delete();
        return redirect()->route('beds.index')->with('success', "Bed deleted.");
    }
}
