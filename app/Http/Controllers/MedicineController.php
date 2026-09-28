<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Http\Requests\StoreMedicineRequest;
use App\Models\Medicine;
use App\Models\User;
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
        $nextNum = (Medicine::max('id') ?? 0) + 1;
        $medicineId = 'MED-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        $medicine = Medicine::create(array_merge(
            $request->validated(),
            ['medicine_id' => $medicineId]
        ));

        $usersToNotify = $this->getPharmacyRecipients();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'New Medicine Added',
            message: "'{$medicine->name}' ({$medicine->generic_name}) was added to the pharmacy inventory with stock level of {$medicine->stock_quantity}.",
            url: route('medicines.show', $medicine->id),
            type: 'medicine_created',
            icon: 'fa-pills',
            color: 'teal'
        );

        return redirect()->route('medicines.index')
            ->with('success', "Medicine '{$medicine->name}' added to pharmacy inventory.");
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
        $oldStock = $medicine->stock_quantity;
        $medicine->update($request->validated());

        $usersToNotify = $this->getPharmacyRecipients();
        $stockStatusMsg = $medicine->stock_quantity <= 20
            ? " (Warning: Stock level is low at {$medicine->stock_quantity})"
            : "";

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Medicine Inventory Updated',
            message: "Details for '{$medicine->name}' have been updated. Current stock: {$medicine->stock_quantity}{$stockStatusMsg}.",
            url: route('medicines.show', $medicine->id),
            type: 'medicine_updated',
            icon: 'fa-box-archive',
            color: 'blue'
        );

        return redirect()->route('medicines.index')
            ->with('success', "Medicine '{$medicine->name}' updated successfully.");
    }

    public function delete(Medicine $medicine)
    {
        return view('medicines.delete', compact('medicine'));
    }

    public function destroy(Medicine $medicine)
    {
        $name = $medicine->name;
        $genericName = $medicine->generic_name;
        $usersToNotify = $this->getPharmacyRecipients();

        $medicine->delete();

        NotificationHelper::notifyUsers(
            users: $usersToNotify,
            title: 'Medicine Removed from Inventory',
            message: "'{$name}' ({$genericName}) has been removed from the pharmacy catalog.",
            url: route('medicines.index'),
            type: 'medicine_deleted',
            icon: 'fa-trash-can',
            color: 'rose'
        );

        return redirect()->route('medicines.index')
            ->with('success', "Medicine '{$name}' removed from inventory.");
    }

    private function getPharmacyRecipients()
    {
        return User::whereIn('role', ['super_admin', 'admin', 'pharmacist', 'doctor', 'nurse'])->get();
    }
}
