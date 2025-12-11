<?php

namespace App\Console\Commands;

use App\Services\OpenStack\OpenStackConnectionService;
use Illuminate\Console\Command;

class TestOpenStackConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openstack:test-connection
                            {--verbose : Show detailed connection information}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the connection to OpenStack and verify all services are accessible';

    /**
     * Execute the console command.
     */
    public function handle(OpenStackConnectionService $service): int
    {
        $this->info('Testing OpenStack connection...');
        $this->newLine();

        // Display configuration
        if ($this->option('verbose')) {
            $this->displayConfiguration();
            $this->newLine();
        }

        try {
            $results = $service->testConnection();

            if ($results['success']) {
                $this->info('✅ Connection successful!');
                $this->newLine();

                // Display service status
                $this->displayServiceStatus($results['services']);

                $this->newLine();
                $this->info("Connected to {$results['services_connected']} out of {$results['total_services']} services.");

                if (!empty($results['errors'])) {
                    $this->newLine();
                    $this->warn('Some services had errors:');
                    foreach ($results['errors'] as $error) {
                        $this->line("  - {$error}");
                    }
                }

                return Command::SUCCESS;
            } else {
                $this->error('❌ Connection failed!');
                $this->newLine();

                if (!empty($results['errors'])) {
                    $this->error('Errors:');
                    foreach ($results['errors'] as $error) {
                        $this->line("  - {$error}");
                    }
                }

                if (isset($results['error'])) {
                    $this->error($results['error']);
                }

                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error('❌ Connection test failed with exception:');
            $this->error($e->getMessage());

            if ($this->option('verbose')) {
                $this->newLine();
                $this->error('Stack trace:');
                $this->line($e->getTraceAsString());
            }

            return Command::FAILURE;
        }
    }

    /**
     * Display the current configuration.
     */
    protected function displayConfiguration(): void
    {
        $this->info('Configuration:');
        $this->table(
            ['Setting', 'Value'],
            [
                ['Auth URL', config('openstack.auth_url')],
                ['Region', config('openstack.region')],
                ['Username', config('openstack.username')],
                ['Project Name', config('openstack.project_name')],
                ['Domain Name', config('openstack.domain_name')],
                ['Timeout', config('openstack.timeout') . 's'],
            ]
        );
    }

    /**
     * Display service status in a table.
     */
    protected function displayServiceStatus(array $services): void
    {
        $rows = [];
        foreach ($services as $name => $service) {
            $status = $service['status'] === 'connected' ? '✅ Connected' : '❌ Error';
            $details = [];

            if (isset($service['flavors_count'])) {
                $details[] = "Flavors: {$service['flavors_count']}";
            }
            if (isset($service['networks_count'])) {
                $details[] = "Networks: {$service['networks_count']}";
            }
            if (isset($service['images_count'])) {
                $details[] = "Images: {$service['images_count']}";
            }
            if (isset($service['error'])) {
                $details[] = "Error: {$service['error']}";
            }

            $rows[] = [
                ucfirst($name),
                $status,
                implode(', ', $details) ?: 'N/A',
            ];
        }

        $this->table(
            ['Service', 'Status', 'Details'],
            $rows
        );
    }
}
