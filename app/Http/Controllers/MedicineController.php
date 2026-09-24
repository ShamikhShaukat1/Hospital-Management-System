<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicineRequest;
use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('generic_name', 'like', "%{$search}%")
                  ->orWhere('medicine_id', 'like', "%{$search}%")
                  ->orWhere('manufacturer', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->input('filter') === 'low_stock') {
            $query->where('stock_quantity', '<=', 20);
        }

        if ($request->input('filter') === 'expired') {
            $query->whereDate('expiry_date', '<', Carbon::today());
        }

        $medicines = $query->orderBy('name')->paginate(15)->withQueryString();
        $categories = Medicine::select('category')->distinct()->pluck('category');

        return view('medicines.index', compact('medicines', 'categories'));
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(StoreMedicineRequest $request)
    {
        $lastMed = Medicine::latest('id')->first();
        $nextNum = $lastMed ? ($lastMed->id + 1) : 1;
        $medicineId = 'MED-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        $medicine = Medicine::create(array_merge(
            $request->validated(),
            ['medicine_id' => $medicineId]
        ));

        return redirect()->route('medicines.index')
            ->with('success', "Medicine {$medicine->name} added to pharmacy inventory.");
    }

    public function show(Medicine $medicine)
    {
        return view('medicines.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        return view('medicines.edit', compact('medicine'));
    }

    public function update(StoreMedicineRequest $request, Medicine $medicine)
    {
        $medicine->update($request->validated());

        return redirect()->route('medicines.index')
            ->with('success', "Medicine {$medicine->name} updated successfully.");
    }

    public function delete(Medicine $medicine)
    {
        return view('medicines.delete', compact('medicine'));
    }

    public function destroy(Medicine $medicine)
    {
        $name = $medicine->name;
        $medicine->delete();

        return redirect()->route('medicines.index')
            ->with('success', "Medicine {$name} removed from inventory.");
    }
}
