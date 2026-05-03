<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Person>
 */
class PersonFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dob = fake()->dateTimeBetween('-70 years', '-12 years');

        return [
            'booking_id' => Booking::factory(),
            'person_id' => 'AR01-001-01',
            'position' => 1,
            'full_name' => fake()->name(),
            'fathers_name' => fake()->name('male'),
            'gender' => fake()->randomElement(['male', 'female']),
            'date_of_birth' => $dob->format('Y-m-d'),
            'passenger_type' => 'adult',
            'relationship' => null,
            'passport_expiry' => fake()->dateTimeBetween('+6 months', '+5 years')->format('Y-m-d'),
            'passport_status' => fake()->randomElement(['pending', 'uploaded', 'approved']),
            'mobile' => '03'.fake()->numerify('#########'),
            'alternate_mobile' => null,
            'email' => fake()->safeEmail(),
            'city' => fake()->randomElement(['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Faisalabad']),
            'wheelchair_required' => false,
            'medical_notes' => null,
            'price_usd' => 1440,
        ];
    }

    public function lead(): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => 1,
            'relationship' => null,
        ]);
    }

    public function familyMember(int $position): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => $position,
            'relationship' => fake()->randomElement(['spouse', 'son', 'daughter', 'parent', 'sibling']),
            'mobile' => null,
            'email' => null,
            'city' => null,
        ]);
    }
}
