<?php

namespace Database\Factories;

use App\Models\OpenStackNetwork;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OpenStackNetwork>
 */
class OpenStackNetworkFactory extends Factory
{
    protected $model = OpenStackNetwork::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'openstack_id' => $this->faker->uuid(),
            'name' => $this->faker->words(2, true) . '-network',
            'description' => $this->faker->sentence(),
            'status' => 'ACTIVE',
            'admin_state_up' => true,
            'shared' => false,
            'external' => false,
            'provider_network_type' => $this->faker->randomElement(['vxlan', 'vlan', 'flat', 'gre']),
            'provider_segmentation_id' => $this->faker->numberBetween(1, 4094),
            'provider_physical_network' => $this->faker->optional()->word(),
            'router_external' => false,
            'availability_zones' => [$this->faker->randomElement(['nova', 'zone1', 'zone2'])],
            'subnets' => [],
            'region' => $this->faker->randomElement(['RegionOne', 'RegionTwo', 'us-east-1']),
            'synced_at' => now(),
        ];
    }

    /**
     * Indicate that the network is external/public.
     */
    public function external(): static
    {
        return $this->state(fn (array $attributes) => [
            'external' => true,
            'router_external' => true,
        ]);
    }

    /**
     * Indicate that the network is shared.
     */
    public function shared(): static
    {
        return $this->state(fn (array $attributes) => [
            'shared' => true,
        ]);
    }
}
