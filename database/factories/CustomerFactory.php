<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone_number' => $this->faker->unique()->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'company_name' => $this->faker->optional()->company(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->countryCode(),
            'status' => $this->faker->randomElement(['pending', 'active', 'inactive', 'suspended']),
            'phone_verified_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'last_login_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'preferences' => [
                'language' => $this->faker->randomElement(['en', 'fa', 'ar']),
                'timezone' => $this->faker->timezone(),
                'notifications' => [
                    'email' => $this->faker->boolean(80),
                    'sms' => $this->faker->boolean(50),
                ],
            ],
            'notes' => $this->faker->optional()->sentence(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the customer is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'phone_verified_at' => now(),
        ]);
    }

    /**
     * Indicate that the customer is pending verification.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'phone_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the customer is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'phone_verified_at' => now(),
            'status' => 'active',
        ]);
    }
}


