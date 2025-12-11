<?php

namespace App\Console\Commands;

use App\Services\OpenStack\OpenStackSyncService;
use Illuminate\Console\Command;

class SyncOpenStackResources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openstack:sync-resources
                            {--type=* : Specific resource types to sync (flavors, images, networks, security_groups)}
                            {--force : Force sync even if sync is disabled in config}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync OpenStack resources (flavors, images, networks, security_groups) to local database';

    /**
     * Execute the console command.
     */
    public function handle(OpenStackSyncService $syncService): int
    {
        // Check if sync is enabled
        if (!config('openstack.sync_enabled', true) && !$this->option('force')) {
            $this->warn('OpenStack sync is disabled in configuration.');
            $this->info('Use --force to override.');
            return Command::FAILURE;
        }

        $this->info('Starting OpenStack resource sync...');
        $this->newLine();

        $types = $this->option('type');
        if (empty($types)) {
            $types = ['flavors', 'images', 'networks', 'security_groups'];
            $this->info('Syncing all resource types: ' . implode(', ', $types));
        } else {
            $this->info('Syncing resource types: ' . implode(', ', $types));
        }

        $this->newLine();

        $startTime = microtime(true);
        $results = $syncService->syncAll($types);

        $totalTime = round(microtime(true) - $startTime, 2);

        // Display results
        $this->displayResults($results);

        $this->newLine();
        $this->info("Total sync time: {$totalTime} seconds");

        // Determine overall success
        $allSuccessful = collect($results)->every(fn($result) => $result['success'] ?? false);

        if ($allSuccessful) {
            $this->info('✅ All sync operations completed successfully!');
            return Command::SUCCESS;
        } else {
            $this->warn('⚠️  Some sync operations had errors. Check the logs for details.');
            return Command::FAILURE;
        }
    }

    /**
     * Display sync results in a formatted table.
     */
    protected function displayResults(array $results): void
    {
        $rows = [];

        foreach ($results as $type => $result) {
            if ($result['success'] ?? false) {
                $stats = $result['stats'] ?? [];
                $rows[] = [
                    ucfirst($type),
                    '✅ Success',
                    $stats['created'] ?? 0,
                    $stats['updated'] ?? 0,
                    $stats['deleted'] ?? 0,
                    $stats['errors'] ? count($stats['errors']) : 0,
                ];
            } else {
                $rows[] = [
                    ucfirst($type),
                    '❌ Failed',
                    '-',
                    '-',
                    '-',
                    $result['error'] ?? 'Unknown error',
                ];
            }
        }

        $this->table(
            ['Resource Type', 'Status', 'Created', 'Updated', 'Deleted', 'Errors'],
            $rows
        );

        // Show detailed errors if any
        foreach ($results as $type => $result) {
            if (isset($result['stats']['errors']) && !empty($result['stats']['errors'])) {
                $this->newLine();
                $this->warn("Errors for {$type}:");
                foreach (array_slice($result['stats']['errors'], 0, 5) as $error) {
                    $this->line("  - " . ($error['error'] ?? json_encode($error)));
                }
                if (count($result['stats']['errors']) > 5) {
                    $this->line("  ... and " . (count($result['stats']['errors']) - 5) . " more errors");
                }
            }
        }
    }
}
