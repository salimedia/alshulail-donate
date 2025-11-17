<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['donation.user', 'donation.project'])->latest()->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['donation.user', 'donation.project']);
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('admin.payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded',
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);
        return redirect()->route('admin.payments.show', $payment)->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully!');
    }

    public function markVerified(Payment $payment)
    {
        $payment->update(['status' => 'completed', 'verified_at' => now()]);
        return response()->json(['success' => true, 'message' => 'Payment marked as verified!']);
    }

    public function markFailed(Payment $payment)
    {
        $payment->update(['status' => 'failed']);
        return response()->json(['success' => true, 'message' => 'Payment marked as failed!']);
    }

    public function reconciliation()
    {
        $payments = Payment::where('status', 'pending')->with(['donation.user', 'donation.project'])->get();
        return view('admin.payments.reconciliation', compact('payments'));
    }
}