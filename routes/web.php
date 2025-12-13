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
use App\Http\Controllers\Admin\LogsMonitoringController as AdminLogsMonitoringController;
use App\Http\Controllers\Admin\NotificationsController as AdminNotificationsController;
use App\Http\Controllers\Admin\BillingController as AdminBillingController;
use App\Http\Controllers\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ServerController as CustomerServerController;
use App\Http\Controllers\Customer\WalletController as CustomerWalletController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\SupportController as CustomerSupportController;
use App\Http\Controllers\Customer\BackupController as CustomerBackupController;
use App\Http\Controllers\Customer\NotificationController as CustomerNotificationController;

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
            Route::post('/networks', [AdminNetworkManagementController::class, 'store'])->name('networks.store');
            Route::get('/networks/{id}', [AdminNetworkManagementController::class, 'show'])->name('networks.show');
            Route::put('/networks/{id}', [AdminNetworkManagementController::class, 'update'])->name('networks.update');
            Route::delete('/networks/{id}', [AdminNetworkManagementController::class, 'destroy'])->name('networks.destroy');
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
            
            // Logs & Monitoring
            Route::get('/logs-monitoring', [AdminLogsMonitoringController::class, 'index'])->name('logs-monitoring.index');
            Route::get('/logs-monitoring/system-logs', [AdminLogsMonitoringController::class, 'systemLogs'])->name('logs-monitoring.system-logs');
            Route::get('/logs-monitoring/failed-provisioning', [AdminLogsMonitoringController::class, 'failedProvisioning'])->name('logs-monitoring.failed-provisioning');
            Route::get('/logs-monitoring/openstack-logs', [AdminLogsMonitoringController::class, 'openstackLogs'])->name('logs-monitoring.openstack-logs');
            Route::get('/logs-monitoring/api-health', [AdminLogsMonitoringController::class, 'apiHealth'])->name('logs-monitoring.api-health');
            
            // Notifications
            Route::get('/notifications', [AdminNotificationsController::class, 'index'])->name('notifications.index');
            Route::get('/notifications/email-templates', [AdminNotificationsController::class, 'emailTemplates'])->name('notifications.email-templates');
            Route::get('/notifications/sms-telegram', [AdminNotificationsController::class, 'smsTelegram'])->name('notifications.sms-telegram');
            Route::get('/notifications/account-alerts', [AdminNotificationsController::class, 'accountAlerts'])->name('notifications.account-alerts');
            Route::get('/notifications/admin-alerts', [AdminNotificationsController::class, 'adminAlerts'])->name('notifications.admin-alerts');
            
            // Billing System
            Route::get('/billing', [AdminBillingController::class, 'index'])->name('billing.index');
            Route::get('/billing/settings', [AdminBillingController::class, 'settings'])->name('billing.settings');
            Route::get('/billing/plans', [AdminBillingController::class, 'plans'])->name('billing.plans');
            Route::get('/billing/plans/create', [AdminBillingController::class, 'createPlan'])->name('billing.plans.create');
            Route::get('/billing/usage-metrics', [AdminBillingController::class, 'usageMetrics'])->name('billing.usage-metrics');
            Route::get('/billing/quotas', [AdminBillingController::class, 'quotas'])->name('billing.quotas');
            Route::get('/billing/coupons', [AdminBillingController::class, 'coupons'])->name('billing.coupons');
            Route::get('/billing/wallets', [AdminBillingController::class, 'wallets'])->name('billing.wallets');
            Route::get('/billing/invoices', [AdminBillingController::class, 'invoices'])->name('billing.invoices');
            Route::get('/billing/invoices/{id}', [AdminBillingController::class, 'showInvoice'])->name('billing.invoices.show');
            Route::get('/billing/transactions', [AdminBillingController::class, 'transactions'])->name('billing.transactions');
            Route::get('/billing/payment-gateways', [AdminBillingController::class, 'paymentGateways'])->name('billing.payment-gateways');
            Route::get('/billing/automations', [AdminBillingController::class, 'automations'])->name('billing.automations');
            Route::get('/billing/credit-system', [AdminBillingController::class, 'creditSystem'])->name('billing.credit-system');
            Route::get('/billing/usage-reports', [AdminBillingController::class, 'usageReports'])->name('billing.usage-reports');
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
            
            // Servers/VPS Routes
            Route::prefix('servers')->name('servers.')->group(function () {
                Route::get('/', [CustomerServerController::class, 'index'])->name('index');
                Route::get('/create', [CustomerServerController::class, 'create'])->name('create');
                Route::post('/', [CustomerServerController::class, 'store'])->name('store');
                Route::get('/{id}', [CustomerServerController::class, 'show'])->name('show');
                Route::post('/{id}/action/{action}', [CustomerServerController::class, 'action'])->name('action');
                
                // API endpoints for fetching resources
                Route::prefix('api')->name('api.')->group(function () {
                    Route::get('/flavors', [CustomerServerController::class, 'getFlavors'])->name('flavors');
                    Route::get('/images', [CustomerServerController::class, 'getImages'])->name('images');
                    Route::get('/networks', [CustomerServerController::class, 'getNetworks'])->name('networks');
                    Route::get('/security-groups', [CustomerServerController::class, 'getSecurityGroups'])->name('security-groups');
                    Route::get('/key-pairs', [CustomerServerController::class, 'getKeyPairs'])->name('key-pairs');
                });
            });
            
            // Storage Routes
            Route::prefix('storage')->name('storage.')->group(function () {
                Route::get('/', function () { return view('customer.storage.index'); })->name('index');
                Route::get('/snapshots', function () { return view('customer.storage.snapshots'); })->name('snapshots');
            });
            
            // Networks Routes
            Route::prefix('networks')->name('networks.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Customer\NetworkController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\Customer\NetworkController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\Customer\NetworkController::class, 'store'])->name('store');
                Route::get('/{id}', [\App\Http\Controllers\Customer\NetworkController::class, 'show'])->name('show');
                Route::get('/security-groups', [\App\Http\Controllers\Customer\NetworkController::class, 'securityGroups'])->name('security-groups');
                Route::get('/floating-ips', [\App\Http\Controllers\Customer\NetworkController::class, 'floatingIps'])->name('floating-ips');
            });
            
            // Backups Routes
            Route::prefix('backups')->name('backups.')->group(function () {
                Route::get('/', [CustomerBackupController::class, 'index'])->name('index');
                Route::get('/create', [CustomerBackupController::class, 'create'])->name('create');
                Route::post('/', [CustomerBackupController::class, 'store'])->name('store');
                Route::get('/{id}/restore', [CustomerBackupController::class, 'showRestore'])->name('restore.show');
                Route::post('/{id}/restore', [CustomerBackupController::class, 'restore'])->name('restore');
                Route::delete('/{id}', [CustomerBackupController::class, 'destroy'])->name('destroy');
                Route::post('/settings', [CustomerBackupController::class, 'updateSettings'])->name('settings.update');
            });
            
            // Notifications Routes
            Route::prefix('notifications')->name('notifications.')->group(function () {
                Route::get('/', [CustomerNotificationController::class, 'index'])->name('index');
                Route::get('/api', [CustomerNotificationController::class, 'getNotifications'])->name('api');
                Route::post('/{id}/read', [CustomerNotificationController::class, 'markAsRead'])->name('read');
                Route::post('/read-all', [CustomerNotificationController::class, 'markAllAsRead'])->name('read-all');
            });
            
            // Billing Routes
            Route::prefix('billing')->name('billing.')->group(function () {
                Route::get('/', function () { return view('customer.billing.index'); })->name('index');
            });
            
            // Invoices Routes
            Route::prefix('invoices')->name('invoices.')->group(function () {
                Route::get('/', function () { return view('customer.invoices.index'); })->name('index');
                Route::get('/export/{format}', function ($format) { 
                    // Export logic will be implemented here
                    return response()->json(['message' => 'Export functionality will be implemented']);
                })->name('export');
                Route::get('/{id}', function ($id) { return view('customer.invoices.show', ['id' => $id]); })->name('show');
            });
            
            // Wallet Routes
            Route::prefix('wallet')->name('wallet.')->group(function () {
                Route::get('/', [CustomerWalletController::class, 'index'])->name('index');
                Route::get('/topup', [CustomerWalletController::class, 'topup'])->name('topup');
                Route::get('/balance', [CustomerWalletController::class, 'getBalance'])->name('balance');
            });
            
            // Usage Routes
            Route::prefix('usage')->name('usage.')->group(function () {
                Route::get('/', function () { return view('customer.usage.index'); })->name('index');
            });
            
            // Support Routes
            Route::prefix('support')->name('support.')->group(function () {
                Route::get('/', [CustomerSupportController::class, 'index'])->name('index');
                Route::get('/create', [CustomerSupportController::class, 'create'])->name('create');
                Route::post('/', [CustomerSupportController::class, 'store'])->name('store');
                Route::get('/{id}', [CustomerSupportController::class, 'show'])->name('show');
                Route::post('/{id}/reply', [CustomerSupportController::class, 'reply'])->name('reply');
                Route::post('/{id}/close', [CustomerSupportController::class, 'close'])->name('close');
            });
            
            // Profile Routes
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/', [CustomerProfileController::class, 'index'])->name('index');
                Route::post('/update', [CustomerProfileController::class, 'updateProfile'])->name('update');
                Route::get('/2fa', [CustomerProfileController::class, 'show2FA'])->name('2fa');
                Route::post('/2fa/enable', [CustomerProfileController::class, 'enable2FA'])->name('2fa.enable');
                Route::post('/2fa/disable', [CustomerProfileController::class, 'disable2FA'])->name('2fa.disable');
                Route::get('/change-password', [CustomerProfileController::class, 'showChangePassword'])->name('change-password');
                Route::post('/change-password', [CustomerProfileController::class, 'changePassword'])->name('change-password.update');
                Route::post('/api-keys', [CustomerProfileController::class, 'createApiKey'])->name('api-keys.create');
                Route::delete('/api-keys/{id}', [CustomerProfileController::class, 'deleteApiKey'])->name('api-keys.delete');
            });
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
