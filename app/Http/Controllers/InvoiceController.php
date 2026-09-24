<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Admission;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['patient', 'payments']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('patient_id', 'like', "%{$search}%");
            })->orWhere('invoice_number', 'like', "%{$search}%");
        }

        $invoices = $query->latest('invoice_date')->paginate(15)->withQueryString();

        return view('billing.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $patients = Patient::where('status', 'active')->get();
        $admissions = Admission::where('status', 'Admitted')->with('patient')->get();
        $selectedPatientId = $request->input('patient_id');

        return view('billing.create', compact('patients', 'admissions', 'selectedPatientId'));
    }

    public function store(StoreInvoiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $lastInv = Invoice::latest('id')->first();
            $nextNum = $lastInv ? ($lastInv->id + 1) : 1;
            $invoiceNumber = 'INV-' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);

            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += ($item['quantity'] * $item['unit_price']);
            }

            $discount = (float) ($request->discount ?? 0);
            $tax = (float) ($request->tax ?? 0);
            $total = max(0, $subtotal - $discount + $tax);

            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'patient_id' => $request->patient_id,
                'admission_id' => $request->admission_id ?? null,
                'invoice_date' => $request->invoice_date,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'status' => 'Unpaid',
            ]);

            foreach ($request->items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            DB::commit();

            return redirect()->route('billing.show', $invoice)
                ->with('success', "Invoice {$invoice->invoice_number} created successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create invoice: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'admission.room', 'items', 'payments']);
        return view('billing.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load('items');
        $patients = Patient::all();
        return view('billing.edit', compact('invoice', 'patients'));
    }

    public function delete(Invoice $invoice)
    {
        return view('billing.delete', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('billing.index')->with('success', "Invoice deleted.");
    }
}
