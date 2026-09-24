<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['invoice.patient', 'patient']);

        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('patient_id', 'like', "%{$search}%");
            })->orWhere('payment_id', 'like', "%{$search}%");
        }

        $payments = $query->latest('payment_date')->paginate(15)->withQueryString();

        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $invoices = Invoice::whereIn('status', ['Unpaid', 'Partial'])->with('patient')->get();
        $selectedInvoiceId = $request->input('invoice_id');
        $selectedInvoice = $selectedInvoiceId ? Invoice::with('patient')->find($selectedInvoiceId) : null;

        return view('payments.create', compact('invoices', 'selectedInvoice'));
    }

    public function store(StorePaymentRequest $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);

        DB::beginTransaction();
        try {
            $lastPay = Payment::latest('id')->first();
            $nextNum = $lastPay ? ($lastPay->id + 1) : 1;
            $paymentId = 'PAY-' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);

            $payment = Payment::create([
                'payment_id' => $paymentId,
                'invoice_id' => $invoice->id,
                'patient_id' => $invoice->patient_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_date' => $request->payment_date,
                'reference' => $request->reference,
                'status' => 'Success',
            ]);

            // Re-calculate total paid
            $totalPaid = (float) $invoice->payments()->where('status', 'Success')->sum('amount');

            if ($totalPaid >= (float) $invoice->total) {
                $invoice->update(['status' => 'Paid']);
            } elseif ($totalPaid > 0) {
                $invoice->update(['status' => 'Partial']);
            }

            DB::commit();

            return redirect()->route('payments.show', $payment)
                ->with('success', "Payment {$payment->payment_id} of \${$payment->amount} recorded successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Payment failed: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Payment $payment)
    {
        $payment->load(['invoice.patient', 'patient']);
        return view('payments.show', compact('payment'));
    }
}
