<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\LanguageController;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Language Switcher
Route::post('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Projects
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Donations
Route::post('/donate', [DonationController::class, 'store'])->name('donations.store');
Route::get('/donations/success', [DonationController::class, 'success'])->name('donations.success');
Route::get('/donations/failed', [DonationController::class, 'failed'])->name('donations.failed');

// Login redirect to admin
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');
