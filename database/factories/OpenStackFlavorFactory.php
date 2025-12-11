<?php

namespace Database\Factories;

use App\Models\OpenStackFlavor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OpenStackFlavor>
 */
class OpenStackFlavorFactory extends Factory
{
    protected $model = OpenStackFlavor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vcpus = $this->faker->randomElement([1, 2, 4, 8, 16]);
        $ram = $vcpus * 2048; // MB
        $disk = $vcpus * 20; // GB

        return [
            'openstack_id' => $this->faker->uuid(),
            'name' => $this->faker->words(2, true) . '-' . $vcpus . 'vcpu',
            'description' => $this->faker->sentence(),
            'vcpus' => $vcpus,
            'ram' => $ram,
            'disk' => $disk,
            'ephemeral_disk' => $this->faker->randomElement([0, 10, 20, 50]),
            'swap' => $this->faker->randomElement([0, 512, 1024, 2048]),
            'is_public' => $this->faker->boolean(80),
            'is_disabled' => false,
            'extra_specs' => [
                'cpu_arch' => 'x86_64',
                'hypervisor_type' => 'QEMU',
            ],
            'pricing_hourly' => $this->faker->randomFloat(4, 0.01, 10.0),
            'pricing_monthly' => $this->faker->randomFloat(2, 10, 500),
            'region' => $this->faker->randomElement(['RegionOne', 'RegionTwo', 'us-east-1']),
            'synced_at' => now(),
        ];
    }

    /**
     * Indicate that the flavor is public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => true,
            'is_disabled' => false,
        ]);
    }

    /**
     * Indicate that the flavor is disabled.
     */
    public function disabled(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_disabled' => true,
        ]);
    }
}
