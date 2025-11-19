<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Donation;
use App\Models\User;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = $this->getQuickStats();
        $recentDonations = $this->getRecentDonations();
        $topProjects = $this->getTopProjects();
        $recentUsers = $this->getRecentUsers();
        $monthlyDonations = $this->getMonthlyDonations();

        return view('admin.dashboard.index', compact(
            'stats',
            'recentDonations',
            'topProjects',
            'recentUsers',
            'monthlyDonations'
        ));
    }

    public function getStats()
    {
        return response()->json($this->getQuickStats());
    }

    public function getDonationCharts()
    {
        $monthlyData = Donation::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');

        $dailyData = Donation::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        return response()->json([
            'monthly' => $monthlyData,
            'daily' => $dailyData,
        ]);
    }

    public function getProjectCharts()
    {
        $categoryData = Project::join('categories', 'projects.category_id', '=', 'categories.id')
            ->select('categories.name_en', DB::raw('COUNT(*) as count'))
            ->groupBy('categories.name_en')
            ->get()
            ->pluck('count', 'name_en');

        $statusData = Project::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        return response()->json([
            'categories' => $categoryData,
            'status' => $statusData,
        ]);
    }

    private function getQuickStats()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        return [
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'active')->count(),
            'total_donations' => Donation::sum('amount'),
            'today_donations' => Donation::whereDate('created_at', $today)->sum('amount'),
            'this_month_donations' => Donation::where('created_at', '>=', $thisMonth)->sum('amount'),
            'last_month_donations' => Donation::whereBetween('created_at', [$lastMonth, $thisMonth])->sum('amount'),
            'total_donors' => User::whereHas('donations')->count() ?? 0,
            'new_donors_today' => User::whereHas('donations', function($q) use ($today) {
                $q->whereDate('created_at', $today);
            })->count(),
            'total_beneficiaries' => Beneficiary::sum('count'),
            'pending_donations' => Donation::where('status', 'pending')->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
            'completion_rate' => $this->getProjectCompletionRate(),
        ];
    }

    private function getRecentDonations()
    {
        return Donation::with(['user', 'project'])
            ->latest()
            ->take(10)
            ->get();
    }

    private function getTopProjects()
    {
        return Project::withCount('donations')
            ->orderByDesc('raised_amount')
            ->take(5)
            ->get();
    }

    private function getRecentUsers()
    {
        return User::latest()
            ->take(5)
            ->get();
    }

    private function getMonthlyDonations()
    {
        return Donation::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(amount) as total, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::createFromDate($item->year, $item->month, 1)->format('M Y'),
                    'total' => $item->total,
                    'count' => $item->count,
                ];
            });
    }

    private function getProjectCompletionRate()
    {
        $totalProjects = Project::count();
        $completedProjects = Project::where('status', 'completed')->count();

        return $totalProjects > 0 ? round(($completedProjects / $totalProjects) * 100, 2) : 0;
    }
}
