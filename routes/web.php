<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;

/*
|--------------------------------------------------------------------------
| Admin Subdomain Routes (hub.aviato.ir)
|--------------------------------------------------------------------------
*/
Route::domain('hub.aviato.ir')
    ->name('admin.')
    ->middleware('guest:web')
    ->group(function () {
        // Authentication Routes
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->withoutMiddleware('guest:web');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->withoutMiddleware('guest:web');
        
        // Landing page for hub subdomain
        Route::get('/', [LandingController::class, 'index'])->name('landing');
        Route::get('/choose-portal', [LandingController::class, 'choosePortal'])->name('choose-portal');
    });

// Admin protected routes
Route::domain('hub.aviato.ir')
    ->name('admin.')
    ->middleware('auth:web')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Customer Subdomain Routes (panel.aviato.ir)
|--------------------------------------------------------------------------
*/
Route::domain('panel.aviato.ir')
    ->name('customer.')
    ->middleware('guest:customer')
    ->group(function () {
        // Authentication Routes
        Route::get('/register', [CustomerAuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [CustomerAuthController::class, 'register'])->withoutMiddleware('guest:customer');
        Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [CustomerAuthController::class, 'login'])->withoutMiddleware('guest:customer');
        
        // Verification Routes
        Route::get('/verify', [CustomerAuthController::class, 'showVerificationForm'])->name('verify');
        Route::post('/verify', [CustomerAuthController::class, 'verify'])->withoutMiddleware('guest:customer');
        Route::post('/verify-login', [CustomerAuthController::class, 'verifyLogin'])->name('verify-login')->withoutMiddleware('guest:customer');
        Route::post('/resend-code', [CustomerAuthController::class, 'resendCode'])->name('resend-code')->withoutMiddleware('guest:customer');
        
        // Logout
        Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout')->withoutMiddleware('guest:customer');
        
        // Landing page for panel subdomain
        Route::get('/', [LandingController::class, 'index'])->name('landing');
    });

// Customer protected routes
Route::domain('panel.aviato.ir')
    ->name('customer.')
    ->middleware('auth:customer')
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Fallback Routes (any other domain)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    $host = request()->getHost();
    if (str_contains($host, 'hub.aviato.ir')) {
        return redirect()->route('admin.login');
    } elseif (str_contains($host, 'panel.aviato.ir')) {
        return redirect()->route('customer.login');
    }
    return redirect('https://hub.aviato.ir');
})->name('login');

Route::get('/', function () {
    $host = request()->getHost();
    if (str_contains($host, 'hub.aviato.ir')) {
        return redirect()->route('admin.landing');
    } elseif (str_contains($host, 'panel.aviato.ir')) {
        return redirect()->route('customer.landing');
    }
    return redirect('https://hub.aviato.ir');
})->name('landing');
