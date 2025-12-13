<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BackupSettings;
use App\Models\BackupSnapshot;
use App\Models\OpenStackInstance;
use App\Services\OpenStack\OpenStackVolumeService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcessScheduledBackups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backups:process-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled backups for customers';

    protected OpenStackVolumeService $volumeService;

    public function __construct(OpenStackVolumeService $volumeService)
    {
        parent::__construct();
        $this->volumeService = $volumeService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Processing scheduled backups...');

        $now = Carbon::now();
        $processed = 0;
        $errors = 0;

        // Get all enabled backup settings where next_backup_at is due
        $dueBackups = BackupSettings::where('enabled', true)
            ->whereNotNull('next_backup_at')
            ->where('next_backup_at', '<=', $now)
            ->with('customer')
            ->get();

        $this->info("Found {$dueBackups->count()} customers with due backups.");

        foreach ($dueBackups as $backupSettings) {
            try {
                $this->processCustomerBackup($backupSettings);
                $processed++;
            } catch (\Exception $e) {
                $errors++;
                Log::error('Failed to process scheduled backup', [
                    'customer_id' => $backupSettings->customer_id,
                    'error' => $e->getMessage(),
                ]);
                $this->error("Failed to process backup for customer {$backupSettings->customer_id}: {$e->getMessage()}");
            }
        }

        // Clean up old snapshots based on retention policy
        $this->cleanupOldSnapshots();

        $this->info("Processed: {$processed}, Errors: {$errors}");
        
        return Command::SUCCESS;
    }

    /**
     * Process backup for a customer.
     */
    protected function processCustomerBackup(BackupSettings $backupSettings)
    {
        $customer = $backupSettings->customer;
        
        if (!$customer) {
            throw new \Exception("Customer not found for backup settings {$backupSettings->id}");
        }

        // Get active instances for this customer
        $instances = OpenStackInstance::forCustomer($customer->id)
            ->where('status', 'active')
            ->whereNotNull('openstack_server_id')
            ->get();

        if ($instances->isEmpty()) {
            $this->warn("No active instances found for customer {$customer->id}");
            // Update next backup time even if no instances
            $backupSettings->calculateNextBackupTime();
            $backupSettings->update([
                'last_backup_at' => Carbon::now(),
                'last_backup_status' => 'success',
            ]);
            return;
        }

        $successCount = 0;
        $errorCount = 0;

        foreach ($instances as $instance) {
            try {
                $snapshotName = $this->generateSnapshotName($instance, $backupSettings->schedule);
                
                // Create snapshot record
                $snapshot = BackupSnapshot::create([
                    'customer_id' => $customer->id,
                    'instance_id' => $instance->id,
                    'name' => $snapshotName,
                    'description' => "پشتیبان خودکار {$backupSettings->schedule}",
                    'openstack_server_id' => $instance->openstack_server_id,
                    'type' => 'automated',
                    'status' => 'creating',
                ]);

                // Create snapshot in OpenStack
                $openstackSnapshot = $this->volumeService->createInstanceSnapshot(
                    $instance->openstack_server_id,
                    $snapshotName,
                    "Automated {$backupSettings->schedule} backup"
                );

                // Update snapshot with OpenStack ID
                $snapshot->update([
                    'openstack_snapshot_id' => $openstackSnapshot['id'],
                    'status' => $openstackSnapshot['status'] === 'active' ? 'available' : 'creating',
                    'size' => $openstackSnapshot['size'] ?? null,
                ]);

                if ($snapshot->status === 'available') {
                    $snapshot->update(['completed_at' => Carbon::now()]);
                }

                $successCount++;

                Log::info('Automated backup created', [
                    'snapshot_id' => $snapshot->id,
                    'customer_id' => $customer->id,
                    'instance_id' => $instance->id,
                ]);
            } catch (\Exception $e) {
                $errorCount++;
                Log::error('Failed to create automated backup', [
                    'customer_id' => $customer->id,
                    'instance_id' => $instance->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Update backup settings
        $backupSettings->update([
            'last_backup_at' => Carbon::now(),
            'last_backup_status' => $errorCount === 0 ? 'success' : ($successCount > 0 ? 'success' : 'failed'),
        ]);

        // Calculate next backup time
        $backupSettings->calculateNextBackupTime();
        $backupSettings->save();

        $this->info("Customer {$customer->id}: {$successCount} successful, {$errorCount} errors");
    }

    /**
     * Generate snapshot name based on schedule and instance.
     */
    protected function generateSnapshotName(OpenStackInstance $instance, string $schedule): string
    {
        $date = Carbon::now()->format('Y-m-d_H-i-s');
        $scheduleLabel = match($schedule) {
            'hourly' => 'hourly',
            'daily' => 'daily',
            'weekly' => 'weekly',
            'monthly' => 'monthly',
            default => 'auto',
        };
        
        return "auto-{$scheduleLabel}-{$instance->name}-{$date}";
    }

    /**
     * Clean up old snapshots based on retention policy.
     */
    protected function cleanupOldSnapshots()
    {
        $this->info('Cleaning up old snapshots...');

        // Get all backup settings with retention policies
        $backupSettings = BackupSettings::where('enabled', true)
            ->where('retention_days', '>', 0)
            ->get();

        $deletedCount = 0;

        foreach ($backupSettings as $settings) {
            $retentionDate = Carbon::now()->subDays($settings->retention_days);

            // Get old automated snapshots
            $oldSnapshots = BackupSnapshot::forCustomer($settings->customer_id)
                ->where('type', 'automated')
                ->where('status', 'available')
                ->where('created_at', '<', $retentionDate)
                ->get();

            foreach ($oldSnapshots as $snapshot) {
                try {
                    // Delete from OpenStack
                    if ($snapshot->openstack_snapshot_id) {
                        try {
                            $this->volumeService->deleteSnapshot($snapshot->openstack_snapshot_id);
                        } catch (\Exception $e) {
                            Log::warning('Failed to delete old snapshot from OpenStack', [
                                'snapshot_id' => $snapshot->id,
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }

                    // Delete local record
                    $snapshot->delete();
                    $deletedCount++;

                    Log::info('Old snapshot deleted', [
                        'snapshot_id' => $snapshot->id,
                        'customer_id' => $settings->customer_id,
                        'age_days' => $snapshot->created_at->diffInDays(Carbon::now()),
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to delete old snapshot', [
                        'snapshot_id' => $snapshot->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        $this->info("Deleted {$deletedCount} old snapshots.");
    }
}
