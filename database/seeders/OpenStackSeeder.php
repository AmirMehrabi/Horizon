<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\OpenStackFlavor;
use App\Models\OpenStackImage;
use App\Models\OpenStackInstance;
use App\Models\OpenStackKeyPair;
use App\Models\OpenStackNetwork;
use App\Models\OpenStackSecurityGroup;
use App\Models\OpenStackSubnet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpenStackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $region = config('openstack.region', 'RegionOne');

        $this->command->info('Seeding OpenStack tables...');
        $this->command->newLine();

        // Seed Flavors
        $this->command->info('Seeding Flavors...');
        $flavors = $this->seedFlavors($region);
        $this->command->info("Created {$flavors->count()} flavors.");
        $this->command->newLine();

        // Seed Images
        $this->command->info('Seeding Images...');
        $images = $this->seedImages($region);
        $this->command->info("Created {$images->count()} images.");
        $this->command->newLine();

        // Seed Networks
        $this->command->info('Seeding Networks...');
        $networks = $this->seedNetworks($region);
        $this->command->info("Created {$networks->count()} networks.");
        $this->command->newLine();

        // Seed Subnets (must be after networks)
        $this->command->info('Seeding Subnets...');
        $subnets = $this->seedSubnets($networks, $region);
        $this->command->info("Created {$subnets->count()} subnets.");
        $this->command->newLine();

        // Seed Security Groups
        $this->command->info('Seeding Security Groups...');
        $securityGroups = $this->seedSecurityGroups($region);
        $this->command->info("Created {$securityGroups->count()} security groups.");
        $this->command->newLine();

        // Seed Key Pairs (optional - only if customers exist)
        if (Customer::count() > 0) {
            $this->command->info('Seeding Key Pairs...');
            $keyPairs = $this->seedKeyPairs($region);
            $this->command->info("Created {$keyPairs->count()} key pairs.");
            $this->command->newLine();
        } else {
            $this->command->warn('No customers found. Skipping key pairs seeding.');
            $this->command->newLine();
        }

        // Seed Instances (optional - only if customers exist)
        if (Customer::count() > 0) {
            $this->command->info('Seeding Instances...');
            $instances = $this->seedInstances($flavors, $images, $networks, $securityGroups, $region);
            $this->command->info("Created {$instances->count()} instances.");
            $this->command->newLine();
        } else {
            $this->command->warn('No customers found. Skipping instances seeding.');
            $this->command->newLine();
        }

        $this->command->info('OpenStack seeding completed!');
    }

    /**
     * Seed flavors.
     */
    protected function seedFlavors(string $region)
    {
        // Create some common flavors
        $commonFlavors = [
            [
                'name' => 'starter',
                'vcpus' => 1,
                'ram' => 2048,
                'disk' => 20,
                'pricing_hourly' => 0.05,
                'pricing_monthly' => 30.00,
            ],
            [
                'name' => 'standard',
                'vcpus' => 2,
                'ram' => 4096,
                'disk' => 40,
                'pricing_hourly' => 0.10,
                'pricing_monthly' => 60.00,
            ],
            [
                'name' => 'pro',
                'vcpus' => 4,
                'ram' => 8192,
                'disk' => 80,
                'pricing_hourly' => 0.20,
                'pricing_monthly' => 120.00,
            ],
            [
                'name' => 'enterprise',
                'vcpus' => 8,
                'ram' => 16384,
                'disk' => 160,
                'pricing_hourly' => 0.40,
                'pricing_monthly' => 240.00,
            ],
        ];

        $flavors = collect();

        foreach ($commonFlavors as $flavorData) {
            $flavor = OpenStackFlavor::factory()
                ->public()
                ->create([
                    'name' => $flavorData['name'],
                    'vcpus' => $flavorData['vcpus'],
                    'ram' => $flavorData['ram'],
                    'disk' => $flavorData['disk'],
                    'pricing_hourly' => $flavorData['pricing_hourly'],
                    'pricing_monthly' => $flavorData['pricing_monthly'],
                    'region' => $region,
                ]);
            $flavors->push($flavor);
        }

        // Create some random flavors
        $randomFlavors = OpenStackFlavor::factory()
            ->count(10)
            ->public()
            ->create([
                'region' => $region,
            ]);

        return $flavors->merge($randomFlavors);
    }

    /**
     * Seed images.
     */
    protected function seedImages(string $region)
    {
        // Create common OS images
        $commonImages = [
            ['name' => 'Ubuntu 22.04 LTS', 'os_type' => 'ubuntu'],
            ['name' => 'Ubuntu 20.04 LTS', 'os_type' => 'ubuntu'],
            ['name' => 'Debian 12', 'os_type' => 'debian'],
            ['name' => 'Debian 11', 'os_type' => 'debian'],
            ['name' => 'CentOS Stream 9', 'os_type' => 'centos'],
            ['name' => 'AlmaLinux 9', 'os_type' => 'almalinux'],
            ['name' => 'Windows Server 2022', 'os_type' => 'windows'],
        ];

        $images = collect();

        foreach ($commonImages as $imageData) {
            $image = OpenStackImage::factory()
                ->public()
                ->create([
                    'name' => $imageData['name'],
                    'metadata' => [
                        'os_type' => $imageData['os_type'],
                        'os_version' => 'latest',
                        'architecture' => 'x86_64',
                    ],
                    'region' => $region,
                ]);
            $images->push($image);
        }

        // Create some random images
        $randomImages = OpenStackImage::factory()
            ->count(5)
            ->public()
            ->create([
                'region' => $region,
            ]);

        return $images->merge($randomImages);
    }

    /**
     * Seed networks.
     */
    protected function seedNetworks(string $region)
    {
        $networks = collect();

        // Create external/public network
        $externalNetwork = OpenStackNetwork::factory()
            ->external()
            ->create([
                'name' => 'public-network',
                'description' => 'Public external network',
                'region' => $region,
            ]);
        $networks->push($externalNetwork);

        // Create shared private network
        $sharedNetwork = OpenStackNetwork::factory()
            ->shared()
            ->create([
                'name' => 'shared-private-network',
                'description' => 'Shared private network',
                'region' => $region,
            ]);
        $networks->push($sharedNetwork);

        // Create some random networks
        $randomNetworks = OpenStackNetwork::factory()
            ->count(5)
            ->create([
                'region' => $region,
            ]);

        return $networks->merge($randomNetworks);
    }

    /**
     * Seed subnets for networks.
     */
    protected function seedSubnets($networks, string $region)
    {
        $subnets = collect();

        foreach ($networks as $network) {
            // Create 1-2 subnets per network
            $subnetCount = rand(1, 2);
            
            for ($i = 0; $i < $subnetCount; $i++) {
                $subnet = OpenStackSubnet::factory()
                    ->create([
                        'network_id' => $network->id,
                        'name' => $network->name . '-subnet-' . ($i + 1),
                        'region' => $region,
                    ]);
                $subnets->push($subnet);
            }
        }

        return $subnets;
    }

    /**
     * Seed security groups.
     */
    protected function seedSecurityGroups(string $region)
    {
        $securityGroups = collect();

        // Create default security group
        $default = OpenStackSecurityGroup::factory()
            ->default()
            ->create([
                'region' => $region,
            ]);
        $securityGroups->push($default);

        // Create web server security group
        $web = OpenStackSecurityGroup::factory()
            ->web()
            ->create([
                'region' => $region,
            ]);
        $securityGroups->push($web);

        // Create some random security groups
        $randomSecurityGroups = OpenStackSecurityGroup::factory()
            ->count(5)
            ->create([
                'region' => $region,
            ]);

        return $securityGroups->merge($randomSecurityGroups);
    }

    /**
     * Seed key pairs for customers.
     */
    protected function seedKeyPairs(string $region)
    {
        $customers = Customer::limit(10)->get();
        
        if ($customers->isEmpty()) {
            return collect();
        }

        $keyPairs = collect();

        foreach ($customers as $customer) {
            // Create 1-3 key pairs per customer
            $keyPairCount = rand(1, 3);
            
            for ($i = 0; $i < $keyPairCount; $i++) {
                $keyPair = OpenStackKeyPair::factory()
                    ->create([
                        'customer_id' => $customer->id,
                        'region' => $region,
                    ]);
                $keyPairs->push($keyPair);
            }
        }

        return $keyPairs;
    }

    /**
     * Seed instances for customers.
     */
    protected function seedInstances($flavors, $images, $networks, $securityGroups, string $region)
    {
        $customers = Customer::limit(5)->get();
        
        if ($customers->isEmpty()) {
            return collect();
        }

        $instances = collect();

        foreach ($customers as $customer) {
            // Create 1-3 instances per customer
            $instanceCount = rand(1, 3);
            
            for ($i = 0; $i < $instanceCount; $i++) {
                $flavor = $flavors->random();
                $image = $images->random();
                $network = $networks->random();
                $securityGroup = $securityGroups->random();
                
                // Get or create a key pair for this customer
                $keyPair = OpenStackKeyPair::where('customer_id', $customer->id)
                    ->where('region', $region)
                    ->first();
                
                if (!$keyPair) {
                    $keyPair = OpenStackKeyPair::factory()->create([
                        'customer_id' => $customer->id,
                        'region' => $region,
                    ]);
                }

                $instance = OpenStackInstance::factory()
                    ->create([
                        'customer_id' => $customer->id,
                        'flavor_id' => $flavor->id,
                        'image_id' => $image->id,
                        'key_pair_id' => $keyPair->id,
                        'region' => $region,
                    ]);

                // Attach network
                $instance->networks()->attach($network->id, [
                    'is_primary' => true,
                ]);

                // Attach security group
                $instance->securityGroups()->attach($securityGroup->id);

                $instances->push($instance);
            }
        }

        return $instances;
    }
}

