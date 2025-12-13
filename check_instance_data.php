<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get the latest instance
$instance = \App\Models\OpenStackInstance::latest()->first();

if (!$instance) {
    echo "No instances found\n";
    exit;
}

echo "Instance ID: {$instance->id}\n";
echo "Instance Name: {$instance->name}\n\n";

$instance->load(['networks', 'securityGroups']);

echo "Networks:\n";
foreach ($instance->networks as $network) {
    echo "  - ID: {$network->id}\n";
    echo "    Name: {$network->name}\n";
    echo "    OpenStack ID: " . ($network->openstack_id ?? 'NULL') . "\n";
    echo "    OpenStack ID type: " . gettype($network->openstack_id) . "\n";
    echo "    OpenStack ID empty?: " . (empty($network->openstack_id) ? 'YES' : 'NO') . "\n";
    echo "\n";
}

echo "Security Groups:\n";
foreach ($instance->securityGroups as $sg) {
    echo "  - ID: {$sg->id}\n";
    echo "    Name: " . ($sg->name ?? 'NULL') . "\n";
    echo "    Name type: " . gettype($sg->name) . "\n";
    echo "    Name empty?: " . (empty($sg->name) ? 'YES' : 'NO') . "\n";
    echo "\n";
}

