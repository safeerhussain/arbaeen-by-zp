<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $group = fake()->randomElement(['AR01', 'AR02']);
        $seq = str_pad(fake()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT);

        return [
            'booking_id' => "{$group}-{$seq}",
            'group' => $group,
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
            'departure_city' => fake()->randomElement(['karachi', 'lahore', 'islamabad']),
            'package_type' => fake()->randomElement(['full', 'ground_only']),
            'campaign_discount' => fake()->boolean(20),
            'heard_about_us' => fake()->randomElement(['whatsapp', 'instagram', 'friend', 'masjid', null]),
            'previous_arbaeen' => fake()->boolean(40),
            'public_feed_consent' => fake()->boolean(60),
            'notes' => null,
            'confirmed_at' => null,
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'confirmed_at' => null,
        ]);
    }

    public function ar01(): static
    {
        return $this->state(fn (array $attributes) => ['group' => 'AR01']);
    }

    public function ar02(): static
    {
        return $this->state(fn (array $attributes) => ['group' => 'AR02']);
    }
}
