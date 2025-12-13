<?php

namespace App\Console\Commands;

use App\Services\OpenStack\OpenStackSyncService;
use Illuminate\Console\Command;

class SyncBackupSnapshots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backups:sync-snapshots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync backup snapshot statuses from OpenStack';

    /**
     * Execute the console command.
     */
    public function handle(OpenStackSyncService $syncService): int
    {
        $this->info('Syncing backup snapshot statuses from OpenStack...');
        $this->newLine();

        $startTime = microtime(true);
        $result = $syncService->syncBackupSnapshots();
        $totalTime = round(microtime(true) - $startTime, 2);

        if ($result['success']) {
            $stats = $result['stats'];
            $this->info("✅ Sync completed successfully!");
            $this->newLine();
            $this->table(
                ['Metric', 'Count'],
                [
                    ['Snapshots Checked', $stats['checked'] ?? 0],
                    ['Snapshots Updated', $stats['updated'] ?? 0],
                    ['Errors', count($stats['errors'] ?? [])],
                ]
            );

            if (!empty($stats['errors'])) {
                $this->newLine();
                $this->warn('Errors encountered:');
                foreach (array_slice($stats['errors'], 0, 5) as $error) {
                    $this->line("  - Snapshot {$error['snapshot_id']}: {$error['error']}");
                }
                if (count($stats['errors']) > 5) {
                    $this->line("  ... and " . (count($stats['errors']) - 5) . " more errors");
                }
            }

            $this->newLine();
            $this->info("Total sync time: {$totalTime} seconds");
            return Command::SUCCESS;
        } else {
            $this->error("❌ Sync failed: " . ($result['error'] ?? 'Unknown error'));
            return Command::FAILURE;
        }
    }
}
