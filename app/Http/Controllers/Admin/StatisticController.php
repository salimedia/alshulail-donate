<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Project;
use App\Models\User;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticController extends Controller
{
    public function index()
    {
        $stats = [
            'total_donations' => Donation::sum('amount'),
            'total_projects' => Project::count(),
            'total_users' => User::count(),
            'monthly_growth' => $this->getMonthlyGrowth(),
        ];

        return view('admin.statistics.index', compact('stats'));
    }

    public function donations(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $year = $request->get('year', now()->year);

        $data = $this->getDonationStatistics($period, $year);
        
        return view('admin.statistics.donations', compact('data', 'period', 'year'));
    }

    public function projects(Request $request)
    {
        $data = [
            'by_category' => Project::join('categories', 'projects.category_id', '=', 'categories.id')
                ->selectRaw('categories.name_en, COUNT(*) as count')
                ->groupBy('categories.name_en')
                ->get(),
            'by_status' => Project::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
        ];

        return view('admin.statistics.projects', compact('data'));
    }

    public function users(Request $request)
    {
        $data = [
            'registrations_by_month' => User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', now()->year)
                ->groupBy('year', 'month')
                ->orderBy('month')
                ->get(),
            'by_country' => User::selectRaw('country, COUNT(*) as count')
                ->whereNotNull('country')
                ->groupBy('country')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
        ];

        return view('admin.statistics.users', compact('data'));
    }

    public function financial(Request $request)
    {
        $data = [
            'revenue_by_month' => Donation::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(amount) as total')
                ->whereYear('created_at', now()->year)
                ->groupBy('year', 'month')
                ->orderBy('month')
                ->get(),
            'top_projects' => Project::orderBy('raised_amount', 'desc')
                ->limit(10)
                ->get(),
        ];

        return view('admin.statistics.financial', compact('data'));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'donations');
        
        // Implementation would depend on requirements
        return response()->download('path/to/export.csv');
    }

    private function getMonthlyGrowth()
    {
        $thisMonth = Donation::whereMonth('created_at', now()->month)->sum('amount');
        $lastMonth = Donation::whereMonth('created_at', now()->subMonth()->month)->sum('amount');
        
        if ($lastMonth > 0) {
            return round((($thisMonth - $lastMonth) / $lastMonth) * 100, 2);
        }
        
        return 0;
    }

    private function getDonationStatistics($period, $year)
    {
        switch ($period) {
            case 'daily':
                return Donation::selectRaw('DAY(created_at) as day, SUM(amount) as total')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', now()->month)
                    ->groupBy('day')
                    ->orderBy('day')
                    ->get();
            
            case 'monthly':
            default:
                return Donation::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
                    ->whereYear('created_at', $year)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
        }
    }
}