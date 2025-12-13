<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$instance = \App\Models\OpenStackInstance::latest()->first();

if (!$instance) {
    echo "Instance not found\n";
    exit;
}

echo "Instance ID: {$instance->id}\n";
echo "OpenStack Server ID: {$instance->openstack_server_id}\n";
echo "Current Status: {$instance->status}\n\n";

try {
    $connection = app(\App\Services\OpenStack\OpenStackConnectionService::class);
    $compute = $connection->getComputeService();
    
    echo "Getting server from OpenStack...\n";
    $server = $compute->getServer(['id' => $instance->openstack_server_id]);
    
    echo "Server class: " . get_class($server) . "\n";
    echo "Status before retrieve: " . ($server->status ?? 'NULL') . "\n\n";
    
    echo "Retrieving server details...\n";
    $server->retrieve();
    
    echo "Status after retrieve: " . ($server->status ?? 'NULL') . "\n";
    echo "Status type: " . gettype($server->status) . "\n";
    
    if (isset($server->status)) {
        $openstackStatus = strtolower(trim($server->status));
        echo "OpenStack Status (lowercase): {$openstackStatus}\n";
        
        $syncService = app(\App\Services\OpenStack\OpenStackSyncService::class);
        $reflection = new ReflectionClass($syncService);
        $method = $reflection->getMethod('mapOpenStackStatus');
        $method->setAccessible(true);
        $mappedStatus = $method->invoke($syncService, $openstackStatus);
        
        echo "Mapped Status: {$mappedStatus}\n";
        
        if ($instance->status !== $mappedStatus) {
            echo "\nStatus needs to be updated from '{$instance->status}' to '{$mappedStatus}'\n";
        } else {
            echo "\nStatus is already correct.\n";
        }
    } else {
        echo "ERROR: Status property not found!\n";
        echo "Available properties: " . implode(', ', array_keys(get_object_vars($server))) . "\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

