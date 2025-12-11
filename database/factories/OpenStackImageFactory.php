<?php

namespace Database\Factories;

use App\Models\OpenStackImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OpenStackImage>
 */
class OpenStackImageFactory extends Factory
{
    protected $model = OpenStackImage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $osTypes = ['Ubuntu', 'Debian', 'CentOS', 'AlmaLinux', 'Windows'];
        $osVersions = ['20.04', '22.04', '12', '9', '2022'];
        $osType = $this->faker->randomElement($osTypes);
        $osVersion = $this->faker->randomElement($osVersions);

        return [
            'openstack_id' => $this->faker->uuid(),
            'name' => $osType . ' ' . $osVersion,
            'description' => $this->faker->sentence(),
            'status' => 'active',
            'visibility' => $this->faker->randomElement(['public', 'private', 'shared']),
            'disk_format' => $this->faker->randomElement(['qcow2', 'raw', 'iso']),
            'container_format' => 'bare',
            'min_disk' => $this->faker->randomElement([10, 20, 40, 80]),
            'min_ram' => $this->faker->randomElement([512, 1024, 2048]),
            'size' => $this->faker->numberBetween(500 * 1024 * 1024, 10 * 1024 * 1024 * 1024), // 500MB to 10GB
            'checksum' => $this->faker->sha256(),
            'owner_id' => $this->faker->uuid(),
            'metadata' => [
                'os_type' => strtolower($osType),
                'os_version' => $osVersion,
                'architecture' => 'x86_64',
            ],
            'region' => $this->faker->randomElement(['RegionOne', 'RegionTwo', 'us-east-1']),
            'synced_at' => now(),
        ];
    }

    /**
     * Indicate that the image is public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibility' => 'public',
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the image is private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibility' => 'private',
        ]);
    }
}
