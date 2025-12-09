<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;

/*
|--------------------------------------------------------------------------
| Main Routes (Path-based instead of subdomain-based for now)
|--------------------------------------------------------------------------
*/

// Fallback login route to redirect to portal selection
Route::get('/login', function () {
    return redirect()->route('choose-portal');
})->name('login');

// Main landing pages
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/choose-portal', [LandingController::class, 'choosePortal'])->name('choose-portal');

/*
|--------------------------------------------------------------------------
| Admin Routes (Path-based: /admin/*)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Authentication Routes
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        // Protected Routes
        Route::middleware('auth:web')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::get('/dashboard', [AdminDashboardController::class, 'index']);
        });
    });

/*
|--------------------------------------------------------------------------
| Customer Routes (Path-based: /customer/*)
|--------------------------------------------------------------------------
*/
Route::prefix('customer')
    ->name('customer.')
    ->group(function () {
        // Authentication Routes
        Route::get('/register', [CustomerAuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [CustomerAuthController::class, 'register']);
        Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [CustomerAuthController::class, 'login']);
        
        // Verification Routes
        Route::get('/verify', [CustomerAuthController::class, 'showVerificationForm'])->name('verify');
        Route::post('/verify', [CustomerAuthController::class, 'verify']);
        Route::post('/verify-login', [CustomerAuthController::class, 'verifyLogin'])->name('verify-login');
        Route::post('/resend-code', [CustomerAuthController::class, 'resendCode'])->name('resend-code');
        
        // Logout
        Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
        
        // Protected Routes
        Route::middleware('auth:customer')->group(function () {
            Route::get('/', [CustomerDashboardController::class, 'index'])->name('dashboard');
            Route::get('/dashboard', [CustomerDashboardController::class, 'index']);
        });
    });
