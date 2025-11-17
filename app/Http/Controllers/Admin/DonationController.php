<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with(['user', 'project', 'payment']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('project', function($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('project')) {
            $query->where('project_id', $request->project);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $donations = $query->latest()->paginate(20);
        $projects = Project::select('id', 'title_en')->get();

        $stats = [
            'total_amount' => $query->sum('amount'),
            'total_count' => $query->count(),
            'average_amount' => $query->avg('amount'),
        ];

        return view('admin.donations.index', compact('donations', 'projects', 'stats'));
    }

    public function show(Donation $donation)
    {
        $donation->load(['user', 'project', 'payment', 'receipt']);
        return view('admin.donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        $projects = Project::where('status', 'active')->get();
        return view('admin.donations.edit', compact('donation', 'projects'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'project_id' => 'required|exists:projects,id',
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email',
            'donor_phone' => 'nullable|string|max:20',
            'is_anonymous' => 'boolean',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Update project raised amount if amount changed
        if ($donation->amount !== $validated['amount'] && $donation->status === 'approved') {
            $difference = $validated['amount'] - $donation->amount;
            $donation->project->increment('raised_amount', $difference);
        }

        $donation->update($validated);

        return redirect()->route('admin.donations.show', $donation)
            ->with('success', 'Donation updated successfully!');
    }

    public function destroy(Donation $donation)
    {
        // Adjust project raised amount if donation was approved
        if ($donation->status === 'approved') {
            $donation->project->decrement('raised_amount', $donation->amount);
            $donation->project->decrement('donors_count');
        }

        $donation->delete();

        return redirect()->route('admin.donations.index')
            ->with('success', 'Donation deleted successfully!');
    }

    public function approve(Donation $donation)
    {
        if ($donation->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending donations can be approved.',
            ], 400);
        }

        $donation->update(['status' => 'approved']);
        
        // Update project statistics
        $donation->project->increment('raised_amount', $donation->amount);
        $donation->project->increment('donors_count');

        return response()->json([
            'success' => true,
            'message' => 'Donation approved successfully!',
        ]);
    }

    public function reject(Donation $donation)
    {
        if ($donation->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending donations can be rejected.',
            ], 400);
        }

        $donation->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Donation rejected successfully!',
        ]);
    }

    public function exportCsv(Request $request)
    {
        $query = Donation::with(['user', 'project']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('project')) {
            $query->where('project_id', $request->project);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $donations = $query->get();

        $filename = 'donations_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($donations) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'ID', 'Donor Name', 'Email', 'Amount', 'Project', 'Status', 
                'Date', 'Payment Method', 'Transaction ID'
            ]);

            // Data rows
            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->id,
                    $donation->user->name ?? $donation->donor_name,
                    $donation->user->email ?? $donation->donor_email,
                    $donation->amount,
                    $donation->project->title_en,
                    $donation->status,
                    $donation->created_at->format('Y-m-d H:i:s'),
                    $donation->payment->payment_method ?? 'N/A',
                    $donation->payment->transaction_id ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $query = Donation::with(['user', 'project']);

        // Apply filters (same as CSV)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $donations = $query->latest()->limit(100)->get(); // Limit for PDF performance

        $pdf = Pdf::loadView('admin.donations.pdf', compact('donations'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('donations_' . now()->format('Y_m_d') . '.pdf');
    }
}