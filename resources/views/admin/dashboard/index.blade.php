@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('page-actions')
<div class="flex space-x-3">
    <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <i class="fas fa-download mr-2"></i>
        Export Report
    </button>
    <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <i class="fas fa-plus mr-2"></i>
        Quick Action
    </button>
</div>
@endsection

@section('content')
<!-- Welcome Message -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-8 text-white mb-8 fade-in-up">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-purple-200">Here's what's happening with your donation platform today.</p>
        </div>
        <div class="hidden lg:block">
            <div class="bg-white bg-opacity-20 rounded-xl p-4">
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ now()->format('H:i') }}</div>
                    <div class="text-sm text-purple-200">{{ now()->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Donations -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover-lift fade-in-up">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Donations</p>
                <p class="text-3xl font-bold text-gray-900">${{ number_format($stats['total_donations'], 2) }}</p>
                @if($stats['this_month_donations'] > $stats['last_month_donations'])
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>
                    +{{ number_format((($stats['this_month_donations'] - $stats['last_month_donations']) / max($stats['last_month_donations'], 1)) * 100, 1) }}%
                </p>
                @endif
            </div>
            <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-green-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-dollar-sign text-white text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Active Projects -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover-lift fade-in-up" style="animation-delay: 0.1s;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Active Projects</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['active_projects'] }}</p>
                <p class="text-sm text-gray-500 mt-1">of {{ $stats['total_projects'] }} total</p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-project-diagram text-white text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Donors -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover-lift fade-in-up" style="animation-delay: 0.2s;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Donors</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_donors']) }}</p>
                <p class="text-sm text-blue-600 mt-1">
                    <i class="fas fa-plus mr-1"></i>
                    {{ $stats['new_donors_today'] }} new today
                </p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-purple-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Beneficiaries -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover-lift fade-in-up" style="animation-delay: 0.3s;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Beneficiaries</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_beneficiaries']) }}</p>
                <p class="text-sm text-orange-600 mt-1">Lives impacted</p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-red-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-heart text-white text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Charts Section -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Donation Trends Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6 fade-in-up">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Donation Trends</h3>
                    <p class="text-sm text-gray-600">Monthly donation amounts over the year</p>
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-xs bg-indigo-100 text-indigo-600 rounded-full">12M</button>
                    <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">6M</button>
                    <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">3M</button>
                </div>
            </div>
            <canvas id="donationChart" height="120"></canvas>
        </div>

        <!-- Project Status Overview -->
        <div class="bg-white rounded-xl shadow-sm p-6 fade-in-up">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Project Status Overview</h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-check text-green-600 text-xl"></i>
                    </div>
                    <p class="text-sm text-gray-600">Completed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completion_rate'] }}%</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-play text-blue-600 text-xl"></i>
                    </div>
                    <p class="text-sm text-gray-600">Active</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_projects'] }}</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto bg-yellow-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-pause text-yellow-600 text-xl"></i>
                    </div>
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_donations'] }}</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <p class="text-sm text-gray-600">Failed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['failed_payments'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Content -->
    <div class="space-y-6">
        <!-- Recent Donations -->
        <div class="bg-white rounded-xl shadow-sm p-6 fade-in-up">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Donations</h3>
                <a href="{{ route('admin.donations.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View all</a>
            </div>
            <div class="space-y-4">
                @forelse($recentDonations->take(5) as $donation)
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-hand-holding-heart text-white"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ $donation->user->name ?? $donation->donor_name }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">{{ $donation->project->title_en }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-green-600">${{ number_format($donation->amount, 2) }}</p>
                        <p class="text-xs text-gray-400">{{ $donation->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">No recent donations</p>
                @endforelse
            </div>
        </div>

        <!-- Top Projects -->
        <div class="bg-white rounded-xl shadow-sm p-6 fade-in-up">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Top Projects</h3>
                <a href="{{ route('admin.projects.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View all</a>
            </div>
            <div class="space-y-4">
                @forelse($topProjects as $project)
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-project-diagram text-white text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $project->title_en }}</p>
                        <div class="flex items-center mt-1">
                            <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full" 
                                     style="width: {{ min(100, $project->progress_percentage) }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500">{{ number_format($project->progress_percentage, 1) }}%</span>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">No projects found</p>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 text-white fade-in-up">
            <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.projects.create') }}" 
                   class="block w-full text-center py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all">
                    <i class="fas fa-plus mr-2"></i>Create Project
                </a>
                <a href="{{ route('admin.users.create') }}" 
                   class="block w-full text-center py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all">
                    <i class="fas fa-user-plus mr-2"></i>Add User
                </a>
                <a href="{{ route('admin.statistics') }}" 
                   class="block w-full text-center py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all">
                    <i class="fas fa-chart-bar mr-2"></i>View Reports
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Donation Trends Chart
    const donationCtx = document.getElementById('donationChart').getContext('2d');
    
    const donationData = @json($monthlyDonations);
    const labels = donationData.map(item => item.month);
    const amounts = donationData.map(item => item.total);
    
    new Chart(donationCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Monthly Donations',
                data: amounts,
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(99, 102, 241)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [2, 2],
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                point: {
                    hoverRadius: 10
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>
@endpush