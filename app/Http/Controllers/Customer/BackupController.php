<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BackupSettings;
use App\Models\BackupSnapshot;
use App\Models\OpenStackInstance;
use App\Services\OpenStack\OpenStackVolumeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BackupController extends Controller
{
    protected OpenStackVolumeService $volumeService;

    public function __construct(OpenStackVolumeService $volumeService)
    {
        $this->volumeService = $volumeService;
    }

    /**
     * Display backup and snapshot dashboard
     */
    public function index(Request $request)
    {
        $customer = $request->user('customer');
        
        // Get backup settings
        $backupSettings = BackupSettings::getOrCreateForCustomer($customer->id);
        
        // Get snapshots for this customer
        $snapshots = BackupSnapshot::forCustomer($customer->id)
            ->with('instance')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($snapshot) {
                return [
                    'id' => $snapshot->id,
                    'name' => $snapshot->name,
                    'description' => $snapshot->description,
                    'server_name' => $snapshot->instance ? $snapshot->instance->name : 'نامشخص',
                    'created_at' => $snapshot->created_at ? $snapshot->created_at->format('Y/m/d - H:i') : 'نامشخص',
                    'size' => $snapshot->size ? round($snapshot->size / (1024 * 1024 * 1024), 2) : 0,
                    'size_unit' => 'GB',
                    'status' => $snapshot->status === 'available' ? 'completed' : ($snapshot->status === 'creating' ? 'creating' : 'error'),
                    'status_label' => $snapshot->status_label,
                ];
            });

        // Format backup settings for view
        $settingsData = [
            'enabled' => $backupSettings->enabled,
            'schedule' => $backupSettings->schedule,
            'time' => $backupSettings->time ? Carbon::parse($backupSettings->time)->format('H:i') : '02:00',
            'retention_days' => $backupSettings->retention_days,
            'last_backup' => $backupSettings->last_backup_at ? $backupSettings->last_backup_at->format('Y/m/d - H:i') : 'هنوز انجام نشده',
            'last_backup_status' => $backupSettings->last_backup_status ?? 'pending',
            'next_backup' => $backupSettings->next_backup_at ? $backupSettings->next_backup_at->format('Y/m/d - H:i') : 'تنظیم نشده',
        ];

        return view('customer.backups.index', [
            'snapshots' => $snapshots,
            'backupSettings' => $settingsData,
        ]);
    }

    /**
     * Show create snapshot form
     */
    public function create(Request $request)
    {
        $customer = $request->user('customer');
        
        // Get active instances for this customer
        $servers = OpenStackInstance::forCustomer($customer->id)
            ->where('status', 'active')
            ->whereNotNull('openstack_server_id')
            ->orderBy('name')
            ->get()
            ->map(function ($instance) {
                return [
                    'id' => $instance->id,
                    'name' => $instance->name,
                ];
            });

        return view('customer.backups.create', compact('servers'));
    }

    /**
     * Store new snapshot
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'server_id' => 'required|uuid|exists:openstack_instances,id',
        ]);

        $customer = $request->user('customer');
        
        // Verify the instance belongs to the customer
        $instance = OpenStackInstance::forCustomer($customer->id)
            ->where('id', $request->server_id)
            ->where('status', 'active')
            ->whereNotNull('openstack_server_id')
            ->firstOrFail();

        DB::beginTransaction();
        
        try {
            // Create snapshot record
            $snapshot = BackupSnapshot::create([
                'customer_id' => $customer->id,
                'instance_id' => $instance->id,
                'name' => $request->name,
                'description' => $request->description,
                'openstack_server_id' => $instance->openstack_server_id,
                'type' => 'manual',
                'status' => 'creating',
            ]);

            // Create snapshot in OpenStack
            $openstackSnapshot = $this->volumeService->createInstanceSnapshot(
                $instance->openstack_server_id,
                $request->name,
                $request->description
            );

            // Update snapshot with OpenStack ID
            $snapshot->update([
                'openstack_snapshot_id' => $openstackSnapshot['id'],
                'status' => $openstackSnapshot['status'] === 'active' ? 'available' : 'creating',
                'size' => $openstackSnapshot['size'] ?? null,
            ]);

            DB::commit();

            Log::info('Snapshot created', [
                'snapshot_id' => $snapshot->id,
                'customer_id' => $customer->id,
                'instance_id' => $instance->id,
            ]);

            return redirect()->route('customer.backups.index')
                ->with('success', 'Snapshot در حال ایجاد است');
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to create snapshot', [
                'customer_id' => $customer->id,
                'instance_id' => $request->server_id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'خطا در ایجاد Snapshot: ' . $e->getMessage());
        }
    }

    /**
     * Show restore confirmation
     */
    public function showRestore($id, Request $request)
    {
        $customer = $request->user('customer');
        
        $snapshot = BackupSnapshot::forCustomer($customer->id)
            ->where('id', $id)
            ->where('status', 'available')
            ->with('instance')
            ->firstOrFail();

        $snapshotData = [
            'id' => $snapshot->id,
            'name' => $snapshot->name,
            'server_name' => $snapshot->instance ? $snapshot->instance->name : 'نامشخص',
            'created_at' => $snapshot->created_at ? $snapshot->created_at->format('Y/m/d - H:i') : 'نامشخص',
            'size' => $snapshot->size ? round($snapshot->size / (1024 * 1024 * 1024), 2) : 0,
            'size_unit' => 'GB',
        ];

        return view('customer.backups.restore', ['snapshot' => $snapshotData]);
    }

    /**
     * Restore snapshot
     */
    public function restore(Request $request, $id)
    {
        $request->validate([
            'confirm' => 'required',
            'new_server_name' => 'required|string|max:255',
        ]);

        $customer = $request->user('customer');
        
        $snapshot = BackupSnapshot::forCustomer($customer->id)
            ->where('id', $id)
            ->where('status', 'available')
            ->with('instance')
            ->firstOrFail();

        if (!$snapshot->openstack_snapshot_id) {
            return redirect()->back()
                ->with('error', 'Snapshot در OpenStack یافت نشد');
        }

        try {
            // Get original instance configuration
            $originalInstance = $snapshot->instance;
            
            if (!$originalInstance) {
                return redirect()->back()
                    ->with('error', 'اطلاعات سرور اصلی یافت نشد');
            }

            // Prepare server configuration for restore
            $serverConfig = [
                'flavor_id' => $originalInstance->flavor->openstack_id ?? null,
                'networks' => $originalInstance->networks->map(function ($network) {
                    return ['uuid' => $network->openstack_id];
                })->toArray(),
            ];

            if ($originalInstance->keyPair) {
                $serverConfig['keyName'] = $originalInstance->keyPair->name;
            }

            // Restore from snapshot (create new instance)
            $newServer = $this->volumeService->restoreFromSnapshot(
                $snapshot->openstack_snapshot_id,
                $request->new_server_name,
                $serverConfig
            );

            Log::info('Snapshot restored', [
                'snapshot_id' => $snapshot->id,
                'customer_id' => $customer->id,
                'new_server_id' => $newServer['id'],
            ]);

            return redirect()->route('customer.servers.index')
                ->with('success', 'بازگردانی Snapshot شروع شد. سرور جدید در حال ایجاد است.');
        } catch (\Exception $e) {
            Log::error('Failed to restore snapshot', [
                'snapshot_id' => $snapshot->id,
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'خطا در بازگردانی Snapshot: ' . $e->getMessage());
        }
    }

    /**
     * Delete snapshot
     */
    public function destroy($id, Request $request)
    {
        $customer = $request->user('customer');
        
        $snapshot = BackupSnapshot::forCustomer($customer->id)
            ->where('id', $id)
            ->firstOrFail();

        DB::beginTransaction();
        
        try {
            // Delete from OpenStack if exists
            if ($snapshot->openstack_snapshot_id) {
                try {
                    $this->volumeService->deleteSnapshot($snapshot->openstack_snapshot_id);
                } catch (\Exception $e) {
                    Log::warning('Failed to delete snapshot from OpenStack', [
                        'snapshot_id' => $snapshot->id,
                        'openstack_snapshot_id' => $snapshot->openstack_snapshot_id,
                        'error' => $e->getMessage(),
                    ]);
                    // Continue with local deletion even if OpenStack deletion fails
                }
            }

            // Delete local record
            $snapshot->delete();

            DB::commit();

            Log::info('Snapshot deleted', [
                'snapshot_id' => $snapshot->id,
                'customer_id' => $customer->id,
            ]);

            return redirect()->route('customer.backups.index')
                ->with('success', 'Snapshot حذف شد');
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to delete snapshot', [
                'snapshot_id' => $snapshot->id,
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'خطا در حذف Snapshot: ' . $e->getMessage());
        }
    }

    /**
     * Update backup settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'enabled' => 'nullable|boolean',
            'schedule' => 'required|in:hourly,daily,weekly,monthly',
            'time' => 'required|date_format:H:i',
            'retention_days' => 'required|integer|min:1|max:365',
        ]);

        $customer = $request->user('customer');
        
        $backupSettings = BackupSettings::getOrCreateForCustomer($customer->id);
        
        $backupSettings->update([
            'enabled' => $request->has('enabled') && $request->enabled == '1',
            'schedule' => $request->schedule,
            'time' => $request->time,
            'retention_days' => $request->retention_days,
        ]);

        // Calculate next backup time
        $backupSettings->calculateNextBackupTime();
        $backupSettings->save();

        Log::info('Backup settings updated', [
            'customer_id' => $customer->id,
            'enabled' => $backupSettings->enabled,
            'schedule' => $backupSettings->schedule,
        ]);

        return redirect()->route('customer.backups.index')
            ->with('success', 'تنظیمات پشتیبان‌گیری به‌روزرسانی شد');
    }
}
