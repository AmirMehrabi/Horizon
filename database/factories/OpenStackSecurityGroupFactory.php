<?php

namespace Database\Factories;

use App\Models\OpenStackSecurityGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OpenStackSecurityGroup>
 */
class OpenStackSecurityGroupFactory extends Factory
{
    protected $model = OpenStackSecurityGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'openstack_id' => $this->faker->uuid(),
            'name' => $this->faker->words(2, true) . '-sg',
            'description' => $this->faker->sentence(),
            'rules' => [
                [
                    'direction' => 'ingress',
                    'protocol' => 'tcp',
                    'port_range_min' => 22,
                    'port_range_max' => 22,
                    'remote_ip_prefix' => '0.0.0.0/0',
                    'ethertype' => 'IPv4',
                ],
                [
                    'direction' => 'ingress',
                    'protocol' => 'tcp',
                    'port_range_min' => 80,
                    'port_range_max' => 80,
                    'remote_ip_prefix' => '0.0.0.0/0',
                    'ethertype' => 'IPv4',
                ],
                [
                    'direction' => 'ingress',
                    'protocol' => 'tcp',
                    'port_range_min' => 443,
                    'port_range_max' => 443,
                    'remote_ip_prefix' => '0.0.0.0/0',
                    'ethertype' => 'IPv4',
                ],
            ],
            'region' => $this->faker->randomElement(['RegionOne', 'RegionTwo', 'us-east-1']),
            'synced_at' => now(),
        ];
    }

    /**
     * Create a default security group.
     */
    public function default(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'default',
            'description' => 'Default security group',
            'rules' => [
                [
                    'direction' => 'ingress',
                    'protocol' => 'tcp',
                    'port_range_min' => 22,
                    'port_range_max' => 22,
                    'remote_ip_prefix' => '0.0.0.0/0',
                    'ethertype' => 'IPv4',
                ],
            ],
        ]);
    }

    /**
     * Create a web server security group.
     */
    public function web(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'web-server',
            'description' => 'Web server security group',
            'rules' => [
                [
                    'direction' => 'ingress',
                    'protocol' => 'tcp',
                    'port_range_min' => 80,
                    'port_range_max' => 80,
                    'remote_ip_prefix' => '0.0.0.0/0',
                    'ethertype' => 'IPv4',
                ],
                [
                    'direction' => 'ingress',
                    'protocol' => 'tcp',
                    'port_range_min' => 443,
                    'port_range_max' => 443,
                    'remote_ip_prefix' => '0.0.0.0/0',
                    'ethertype' => 'IPv4',
                ],
                [
                    'direction' => 'ingress',
                    'protocol' => 'tcp',
                    'port_range_min' => 22,
                    'port_range_max' => 22,
                    'remote_ip_prefix' => '0.0.0.0/0',
                    'ethertype' => 'IPv4',
                ],
            ],
        ]);
    }
}

