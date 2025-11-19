<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BeneficiaryController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

// Admin Authentication Routes (not protected by admin middleware)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
});

// Protected Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    
    // Quick Stats API
    Route::get('/api/stats', [DashboardController::class, 'getStats'])->name('admin.api.stats');
    Route::get('/api/charts/donations', [DashboardController::class, 'getDonationCharts'])->name('admin.api.charts.donations');
    Route::get('/api/charts/projects', [DashboardController::class, 'getProjectCharts'])->name('admin.api.charts.projects');
    
    // Projects Management
    Route::resource('projects', ProjectController::class)->names('admin.projects');
    Route::post('/projects/{project}/toggle-featured', [ProjectController::class, 'toggleFeatured'])->name('admin.projects.toggle-featured');
    Route::post('/projects/{project}/toggle-urgent', [ProjectController::class, 'toggleUrgent'])->name('admin.projects.toggle-urgent');
    Route::post('/projects/{project}/upload-images', [ProjectController::class, 'uploadImages'])->name('admin.projects.upload-images');
    Route::delete('/projects/{project}/media/{media}', [ProjectController::class, 'deleteMedia'])->name('admin.projects.delete-media');
    Route::post('/projects/{project}/restore', [ProjectController::class, 'restore'])->name('admin.projects.restore')->withTrashed();
    Route::delete('/projects/{project}/force-delete', [ProjectController::class, 'forceDelete'])->name('admin.projects.force-delete')->withTrashed();
    
    // Categories Management
    Route::resource('categories', CategoryController::class)->names('admin.categories');
    Route::post('/categories/{category}/toggle-active', [CategoryController::class, 'toggleActive'])->name('admin.categories.toggle-active');
    
    // Donations Management
    Route::resource('donations', DonationController::class)->except(['create', 'store'])->names('admin.donations');
    Route::post('/donations/{donation}/approve', [DonationController::class, 'approve'])->name('admin.donations.approve');
    Route::post('/donations/{donation}/reject', [DonationController::class, 'reject'])->name('admin.donations.reject');
    Route::get('/donations/export/csv', [DonationController::class, 'exportCsv'])->name('admin.donations.export.csv');
    Route::get('/donations/export/pdf', [DonationController::class, 'exportPdf'])->name('admin.donations.export.pdf');
    
    // Users Management
    Route::resource('users', UserController::class)->names('admin.users');
    Route::get('/users/{user}/change-password', [UserController::class, 'changePassword'])->name('admin.users.change-password');
    Route::post('/users/{user}/update-password', [UserController::class, 'updatePassword'])->name('admin.users.update-password');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('admin.users.assign-role');
    Route::post('/users/{user}/impersonate', [UserController::class, 'impersonate'])->name('admin.users.impersonate');
    Route::post('/users/stop-impersonating', [UserController::class, 'stopImpersonating'])->name('admin.users.stop-impersonating');
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('admin.users.restore')->withTrashed();
    Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('admin.users.force-delete')->withTrashed();
    
    // Beneficiaries Management
    Route::resource('beneficiaries', BeneficiaryController::class)->names('admin.beneficiaries');
    Route::get('/beneficiaries/export/csv', [BeneficiaryController::class, 'exportCsv'])->name('admin.beneficiaries.export.csv');
    
    // Payments Management
    Route::resource('payments', PaymentController::class)->except(['create', 'store'])->names('admin.payments');
    Route::post('/payments/{payment}/mark-verified', [PaymentController::class, 'markVerified'])->name('admin.payments.mark-verified');
    Route::post('/payments/{payment}/mark-failed', [PaymentController::class, 'markFailed'])->name('admin.payments.mark-failed');
    Route::get('/payments/reconciliation', [PaymentController::class, 'reconciliation'])->name('admin.payments.reconciliation');
    
    // Pages Management
    Route::resource('pages', PageController::class)->names('admin.pages');
    Route::post('/pages/{page}/toggle-published', [PageController::class, 'togglePublished'])->name('admin.pages.toggle-published');
    
    // Statistics & Reports
    Route::get('/statistics', [StatisticController::class, 'index'])->name('admin.statistics');
    Route::get('/statistics/donations', [StatisticController::class, 'donations'])->name('admin.statistics.donations');
    Route::get('/statistics/projects', [StatisticController::class, 'projects'])->name('admin.statistics.projects');
    Route::get('/statistics/users', [StatisticController::class, 'users'])->name('admin.statistics.users');
    Route::get('/statistics/financial', [StatisticController::class, 'financial'])->name('admin.statistics.financial');
    Route::get('/statistics/export', [StatisticController::class, 'export'])->name('admin.statistics.export');
    
    // Audit Logs
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs');
    Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('admin.audit-logs.show');
    Route::delete('/audit-logs/cleanup', [AuditLogController::class, 'cleanup'])->name('admin.audit-logs.cleanup');
    
    // Settings Management
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
    Route::post('/settings/logo', [SettingController::class, 'uploadLogo'])->name('admin.settings.upload-logo');
    Route::post('/settings/favicon', [SettingController::class, 'uploadFavicon'])->name('admin.settings.upload-favicon');
    Route::post('/settings/backup', [SettingController::class, 'backup'])->name('admin.settings.backup');
    Route::post('/settings/maintenance', [SettingController::class, 'toggleMaintenance'])->name('admin.settings.maintenance');
});