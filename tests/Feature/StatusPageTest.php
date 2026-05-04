<?php

use App\Models\Booking;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the status page', function () {
    $this->get(route('status'))->assertStatus(200)->assertSee('Check Booking Status');
});

it('returns empty state when no booking_id is submitted', function () {
    $this->get(route('status'))->assertStatus(200)->assertSee('Enter your booking reference above');
});

it('shows booking details for a valid booking_id', function () {
    $booking = Booking::factory()->create(['booking_id' => 'AR01-005', 'group' => 'AR01']);
    Person::factory()->lead()->create(['booking_id' => $booking->id, 'full_name' => 'Zahra Hussain']);

    $this->get(route('status', ['booking_id' => 'AR01-005']))
        ->assertStatus(200)
        ->assertSee('AR01-005')
        ->assertSee('Zahra Hussain');
});

it('is case-insensitive for booking_id lookup', function () {
    Booking::factory()->create(['booking_id' => 'AR02-010']);

    $this->get(route('status', ['booking_id' => 'ar02-010']))
        ->assertStatus(200)
        ->assertSee('AR02-010');
});

it('shows error message when booking_id not found', function () {
    $this->get(route('status', ['booking_id' => 'AR01-999']))
        ->assertStatus(200)
        ->assertSee('No booking found');
});
