<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\OpenStackKeyPair;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OpenStackKeyPair>
 */
class OpenStackKeyPairFactory extends Factory
{
    protected $model = OpenStackKeyPair::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a realistic SSH public key
        $publicKey = 'ssh-rsa ' . base64_encode($this->faker->text(200)) . ' ' . $this->faker->email();
        
        return [
            'customer_id' => Customer::factory(),
            'openstack_id' => $this->faker->uuid(),
            'name' => $this->faker->words(2, true) . '-key',
            'public_key' => $publicKey,
            'private_key' => null, // Private keys should not be stored in seeders
            'fingerprint' => $this->faker->sha256(),
            'region' => $this->faker->randomElement(['RegionOne', 'RegionTwo', 'us-east-1']),
        ];
    }

    /**
     * Indicate that the key pair has a private key (for testing only).
     */
    public function withPrivateKey(): static
    {
        return $this->state(fn (array $attributes) => [
            'private_key' => '-----BEGIN RSA PRIVATE KEY-----\n' . 
                           base64_encode($this->faker->text(500)) . 
                           '\n-----END RSA PRIVATE KEY-----',
        ]);
    }
}






