<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with(['user']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $auditLogs = $query->latest()->paginate(50);
        
        return view('admin.audit-logs.index', compact('auditLogs'));
    }

    public function show(AuditLog $auditLog)
    {
        $auditLog->load(['user']);
        return view('admin.audit-logs.show', compact('auditLog'));
    }

    public function cleanup(Request $request)
    {
        $days = $request->input('days', 90);
        $deleted = AuditLog::where('created_at', '<', now()->subDays($days))->delete();
        
        return response()->json([
            'success' => true, 
            'message' => "Deleted {$deleted} audit log entries older than {$days} days."
        ]);
    }
}