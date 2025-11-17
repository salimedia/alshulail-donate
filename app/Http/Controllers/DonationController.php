<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:10',
            'payment_method' => 'required|in:mada,visa,mastercard,bank_transfer',
            'is_gift' => 'nullable|boolean',
            'gift_recipient_name' => 'required_if:is_gift,1',
            'gift_recipient_email' => 'required_if:is_gift,1|email',
            'gift_occasion' => 'nullable|string',
            'gift_message' => 'nullable|string',
            'gift_delivery_date' => 'nullable|date|after:today',
        ]);

        // Get project
        $project = Project::findOrFail($validated['project_id']);

        // Create donation
        $donation = Donation::create([
            'user_id' => auth()->id(),
            'project_id' => $project->id,
            'category_id' => $project->category_id,
            'amount' => $validated['amount'],
            'currency' => 'SAR',
            'status' => 'pending',
            'is_gift' => $request->boolean('is_gift'),
            'gift_recipient_name' => $request->gift_recipient_name,
            'gift_recipient_email' => $request->gift_recipient_email,
            'gift_occasion' => $request->gift_occasion,
            'gift_message' => $request->gift_message,
            'gift_delivery_date' => $request->gift_delivery_date,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Create payment record
        $transactionId = 'TXN-' . strtoupper(Str::random(12));

        $payment = Payment::create([
            'transaction_id' => $transactionId,
            'donation_id' => $donation->id,
            'amount' => $validated['amount'],
            'currency' => 'SAR',
            'payment_method' => $validated['payment_method'],
            'payment_gateway' => 'demo', // In production: hyperpay, moyasar, etc.
            'status' => 'pending',
            'net_amount' => $validated['amount'],
        ]);

        // Simulate payment processing (in production, redirect to payment gateway)
        // For demo purposes, we'll mark it as completed
        $paymentSuccess = $this->processPayment($payment, $validated['payment_method']);

        if ($paymentSuccess) {
            // Update payment status
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
                'gateway_transaction_id' => 'DEMO-' . Str::random(16),
            ]);

            // Update donation status
            $donation->update(['status' => 'completed']);

            // Update project stats
            $project->increment('raised_amount', $validated['amount']);
            $project->increment('donors_count');

            // Generate receipt
            $this->generateReceipt($donation);

            // Redirect to success page
            return redirect()->route('donations.success', ['donation' => $donation->donation_number]);
        } else {
            // Update payment status
            $payment->update([
                'status' => 'failed',
                'failure_reason' => 'Payment processing failed',
            ]);

            // Update donation status
            $donation->update(['status' => 'failed']);

            // Redirect to failure page
            return redirect()->route('donations.failed', ['donation' => $donation->donation_number]);
        }
    }

    public function success(Request $request)
    {
        $donationNumber = $request->query('donation');
        $donation = null;

        if ($donationNumber) {
            $donation = Donation::with(['project', 'receipt'])
                ->where('donation_number', $donationNumber)
                ->first();
        }

        return view('donations.success', compact('donation'));
    }

    public function failed(Request $request)
    {
        $donationNumber = $request->query('donation');
        $donation = null;

        if ($donationNumber) {
            $donation = Donation::with('project')
                ->where('donation_number', $donationNumber)
                ->first();
        }

        return view('donations.failed', compact('donation'));
    }

    /**
     * Simulate payment processing
     * In production, this would integrate with actual payment gateways
     */
    private function processPayment($payment, $paymentMethod)
    {
        // Simulate 95% success rate
        return rand(1, 100) <= 95;

        // In production, you would:
        // 1. Redirect to payment gateway
        // 2. Handle webhook callbacks
        // 3. Verify payment status
        // 4. Update records accordingly
    }

    /**
     * Generate receipt for completed donation
     */
    private function generateReceipt($donation)
    {
        $receiptNumber = 'RCP-' . date('Ymd') . '-' . str_pad($donation->id, 6, '0', STR_PAD_LEFT);

        Receipt::create([
            'receipt_number' => $receiptNumber,
            'donation_id' => $donation->id,
            'user_id' => $donation->user_id,
            'amount' => $donation->amount,
            'currency' => $donation->currency,
            'is_tax_receipt' => true,
            'issued_at' => now(),
        ]);

        // In production:
        // 1. Generate PDF using DomPDF
        // 2. Send email to donor
        // 3. If gift donation, send gift card email
    }
}
