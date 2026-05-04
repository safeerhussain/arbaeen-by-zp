<?php

use App\Models\Booking;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns seat counts as JSON', function () {
    $this->getJson(route('api.counts'))
        ->assertStatus(200)
        ->assertJsonStructure(['ar01_confirmed', 'ar02_confirmed', 'capacity'])
        ->assertJson(['ar01_confirmed' => 0, 'ar02_confirmed' => 0, 'capacity' => 135]);
});

it('counts only confirmed persons in seat counts', function () {
    $confirmed = Booking::factory()->ar01()->confirmed()->create();
    Person::factory()->lead()->create(['booking_id' => $confirmed->id]);
    Person::factory()->familyMember(2)->create(['booking_id' => $confirmed->id]);

    $pending = Booking::factory()->ar01()->pending()->create();
    Person::factory()->lead()->create(['booking_id' => $pending->id]);

    $this->getJson(route('api.counts'))
        ->assertJson(['ar01_confirmed' => 2, 'ar02_confirmed' => 0]);
});

it('returns social proof feed as JSON array', function () {
    $this->getJson(route('api.feed'))
        ->assertStatus(200)
        ->assertJsonIsArray();
});

it('only includes consented bookings in feed', function () {
    $consented = Booking::factory()->pending()->create(['public_feed_consent' => true]);
    Person::factory()->lead()->create(['booking_id' => $consented->id, 'full_name' => 'Ahmad Khan', 'city' => 'Karachi']);

    $notConsented = Booking::factory()->pending()->create(['public_feed_consent' => false]);
    Person::factory()->lead()->create(['booking_id' => $notConsented->id, 'full_name' => 'Secret Person', 'city' => 'Lahore']);

    $response = $this->getJson(route('api.feed'));
    $response->assertStatus(200);

    $data = $response->json();
    $names = collect($data)->pluck('name');
    expect($names)->toContain('Ahmad')
        ->not->toContain('Secret');
});

it('returns first name only in feed', function () {
    $booking = Booking::factory()->pending()->create(['public_feed_consent' => true]);
    Person::factory()->lead()->create([
        'booking_id' => $booking->id,
        'full_name' => 'Muhammad Ali Hussain',
        'city' => 'Lahore',
    ]);

    $data = $this->getJson(route('api.feed'))->json();
    expect($data[0]['name'])->toBe('Muhammad');
});
