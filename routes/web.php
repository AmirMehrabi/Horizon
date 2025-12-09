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
    ->group(function () {
        // Logout route (accessible to authenticated users)
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        // Guest routes (login, landing)
        Route::middleware('guest:web')->group(function () {
            Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [AdminAuthController::class, 'login']);
            Route::get('/', [LandingController::class, 'index'])->name('landing');
            Route::get('/choose-portal', [LandingController::class, 'choosePortal'])->name('choose-portal');
        });
        
        // Protected routes (dashboard)
        Route::middleware('auth:web')->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        });
    });

/*
|--------------------------------------------------------------------------
| Customer Subdomain Routes (panel.aviato.ir)
|--------------------------------------------------------------------------
*/
Route::domain('panel.aviato.ir')
    ->name('customer.')
    ->group(function () {
        // Logout route (accessible to authenticated users)
        Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
        
        // Guest routes (login, register, verification)
        Route::middleware('guest:customer')->group(function () {
            Route::get('/register', [CustomerAuthController::class, 'showRegistrationForm'])->name('register');
            Route::post('/register', [CustomerAuthController::class, 'register']);
            Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [CustomerAuthController::class, 'login']);
            
            // Verification Routes
            Route::get('/verify', [CustomerAuthController::class, 'showVerificationForm'])->name('verify');
            Route::post('/verify', [CustomerAuthController::class, 'verify']);
            Route::post('/verify-login', [CustomerAuthController::class, 'verifyLogin'])->name('verify-login');
            Route::post('/resend-code', [CustomerAuthController::class, 'resendCode'])->name('resend-code');
            
            // Root redirects to login
            Route::get('/', function () {
                return redirect()->route('customer.login');
            });
        });
        
        // Protected routes (dashboard)
        Route::middleware('auth:customer')->group(function () {
            Route::get('/', [CustomerDashboardController::class, 'index'])->name('dashboard');
            Route::get('/dashboard', [CustomerDashboardController::class, 'index']);
        });
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
