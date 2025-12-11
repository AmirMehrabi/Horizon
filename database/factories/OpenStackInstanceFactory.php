<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\OpenStackFlavor;
use App\Models\OpenStackImage;
use App\Models\OpenStackInstance;
use App\Models\OpenStackKeyPair;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OpenStackInstance>
 */
class OpenStackInstanceFactory extends Factory
{
    protected $model = OpenStackInstance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'name' => $this->faker->words(3, true) . '-server',
            'description' => $this->faker->sentence(),
            'openstack_server_id' => $this->faker->optional()->uuid(),
            'openstack_project_id' => $this->faker->uuid(),
            'status' => $this->faker->randomElement(['pending', 'building', 'active', 'stopped']),
            'flavor_id' => OpenStackFlavor::factory(),
            'image_id' => OpenStackImage::factory(),
            'key_pair_id' => OpenStackKeyPair::factory(),
            'root_password_hash' => null,
            'user_data' => null,
            'config_drive' => false,
            'region' => $this->faker->randomElement(['RegionOne', 'RegionTwo', 'us-east-1']),
            'availability_zone' => $this->faker->randomElement(['nova', 'zone1', 'zone2']),
            'metadata' => [
                'created_by' => 'system',
            ],
            'auto_billing' => true,
            'billing_cycle' => $this->faker->randomElement(['hourly', 'monthly']),
            'hourly_cost' => $this->faker->randomFloat(4, 0.01, 5.0),
            'monthly_cost' => $this->faker->randomFloat(2, 10, 300),
            'billing_started_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'last_billed_at' => $this->faker->optional()->dateTimeBetween('-1 week', 'now'),
            'ip_addresses' => [
                'public' => [$this->faker->optional()->ipv4()],
                'private' => [$this->faker->ipv4()],
            ],
            'synced_at' => $this->faker->optional()->dateTimeBetween('-1 day', 'now'),
            'last_openstack_status' => null,
        ];
    }

    /**
     * Indicate that the instance is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'openstack_server_id' => $this->faker->uuid(),
            'synced_at' => now(),
        ]);
    }

    /**
     * Indicate that the instance is building.
     */
    public function building(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'building',
            'openstack_server_id' => null,
        ]);
    }

    /**
     * Indicate that the instance is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'openstack_server_id' => null,
        ]);
    }

    /**
     * Indicate that the instance uses hourly billing.
     */
    public function hourlyBilling(): static
    {
        return $this->state(fn (array $attributes) => [
            'billing_cycle' => 'hourly',
        ]);
    }

    /**
     * Indicate that the instance uses monthly billing.
     */
    public function monthlyBilling(): static
    {
        return $this->state(fn (array $attributes) => [
            'billing_cycle' => 'monthly',
        ]);
    }
}
