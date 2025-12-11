<?php

namespace Database\Factories;

use App\Models\OpenStackNetwork;
use App\Models\OpenStackSubnet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OpenStackSubnet>
 */
class OpenStackSubnetFactory extends Factory
{
    protected $model = OpenStackSubnet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ipVersion = $this->faker->randomElement([4, 6]);
        
        // Generate realistic CIDR blocks
        if ($ipVersion === 4) {
            $baseIp = $this->faker->randomElement(['10.0', '172.16', '192.168']);
            $subnet = $this->faker->numberBetween(0, 255);
            $prefix = $this->faker->randomElement([24, 25, 26]);
            $cidr = "{$baseIp}.{$subnet}.0/{$prefix}";
        } else {
            $cidr = $this->faker->ipv6() . '/64';
        }

        return [
            'openstack_id' => $this->faker->uuid(),
            'network_id' => OpenStackNetwork::factory(),
            'name' => $this->faker->words(2, true) . '-subnet',
            'description' => $this->faker->sentence(),
            'cidr' => $cidr,
            'ip_version' => $ipVersion,
            'gateway_ip' => $this->faker->optional()->ipv4(),
            'enable_dhcp' => true,
            'dns_nameservers' => [
                $this->faker->ipv4(),
                $this->faker->ipv4(),
            ],
            'allocation_pools' => [
                [
                    'start' => $this->faker->ipv4(),
                    'end' => $this->faker->ipv4(),
                ],
            ],
            'host_routes' => [],
            'region' => $this->faker->randomElement(['RegionOne', 'RegionTwo', 'us-east-1']),
            'synced_at' => now(),
        ];
    }

    /**
     * Indicate that DHCP is disabled.
     */
    public function withoutDhcp(): static
    {
        return $this->state(fn (array $attributes) => [
            'enable_dhcp' => false,
        ]);
    }
}

