<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController as AdminUserManagementController;
use App\Http\Controllers\Admin\ProjectManagementController as AdminProjectManagementController;
use App\Http\Controllers\Admin\ComputeController as AdminComputeController;
use App\Http\Controllers\Admin\ImageManagementController as AdminImageManagementController;
use App\Http\Controllers\Admin\NetworkManagementController as AdminNetworkManagementController;
use App\Http\Controllers\Admin\StorageManagementController as AdminStorageManagementController;
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
            Route::get('/choose-portal', [LandingController::class, 'choosePortal'])->name('choose-portal');
            
            // Root redirects to login for unauthenticated users
            Route::get('/', function () {
                return redirect()->route('admin.login');
            });
        });
        
        // Protected routes (dashboard)
        Route::middleware('auth:web')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::get('/dashboard', [AdminDashboardController::class, 'index']);
            Route::get('/users', [AdminUserManagementController::class, 'index'])->name('users.index');
            Route::get('/projects', [AdminProjectManagementController::class, 'index'])->name('projects.index');
            Route::get('/compute', [AdminComputeController::class, 'index'])->name('compute.index');
            Route::get('/compute/{id}', [AdminComputeController::class, 'show'])->name('compute.show');
            Route::get('/images', [AdminImageManagementController::class, 'index'])->name('images.index');
            Route::get('/images/{id}', [AdminImageManagementController::class, 'show'])->name('images.show');
            
            // Network Management
            Route::get('/networks', [AdminNetworkManagementController::class, 'index'])->name('networks.index');
            Route::get('/networks/{id}', [AdminNetworkManagementController::class, 'show'])->name('networks.show');
            Route::get('/networks/routers', [AdminNetworkManagementController::class, 'routers'])->name('networks.routers');
            Route::get('/networks/routers/{id}', [AdminNetworkManagementController::class, 'routerShow'])->name('networks.routers.show');
            Route::get('/networks/floating-ips', [AdminNetworkManagementController::class, 'floatingIps'])->name('networks.floating-ips');
            Route::get('/networks/security-groups', [AdminNetworkManagementController::class, 'securityGroups'])->name('networks.security-groups');
            Route::get('/networks/security-groups/{id}', [AdminNetworkManagementController::class, 'securityGroupShow'])->name('networks.security-groups.show');
            Route::get('/networks/load-balancers', [AdminNetworkManagementController::class, 'loadBalancers'])->name('networks.load-balancers');
            Route::get('/networks/load-balancers/{id}', [AdminNetworkManagementController::class, 'loadBalancerShow'])->name('networks.load-balancers.show');
            
            // Storage Management
            Route::get('/storage', [AdminStorageManagementController::class, 'index'])->name('storage.index');
            Route::get('/storage/volumes', [AdminStorageManagementController::class, 'volumes'])->name('storage.volumes');
            Route::get('/storage/volumes/{id}', [AdminStorageManagementController::class, 'showVolume'])->name('storage.volumes.show');
            Route::get('/storage/volume-types', [AdminStorageManagementController::class, 'volumeTypes'])->name('storage.volume-types');
            Route::get('/storage/snapshots', [AdminStorageManagementController::class, 'snapshots'])->name('storage.snapshots');
            Route::get('/storage/containers', [AdminStorageManagementController::class, 'containers'])->name('storage.containers');
            Route::get('/storage/containers/{id}', [AdminStorageManagementController::class, 'showContainer'])->name('storage.containers.show');
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
        return redirect()->route('customer.login');
    }
    return redirect('https://hub.aviato.ir');
})->name('landing');
