<?php

use App\Models\Booking;
use App\Models\PaymentStage;
use App\Models\Person;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a booking via factory', function () {
    $booking = Booking::factory()->create();

    expect($booking->id)->toBeInt()
        ->and($booking->booking_id)->toMatch('/^AR0[12]-\d{3}$/')
        ->and($booking->group)->toBeIn(['AR01', 'AR02'])
        ->and($booking->status)->toBeIn(['pending', 'confirmed', 'cancelled'])
        ->and($booking->departure_city)->toBeIn(['karachi', 'lahore', 'islamabad']);
});

it('uses confirmed state', function () {
    $booking = Booking::factory()->confirmed()->create();

    expect($booking->status)->toBe('confirmed')
        ->and($booking->confirmed_at)->not->toBeNull()
        ->and($booking->isConfirmed())->toBeTrue();
});

it('uses pending state', function () {
    $booking = Booking::factory()->pending()->create();

    expect($booking->status)->toBe('pending')
        ->and($booking->confirmed_at)->toBeNull()
        ->and($booking->isConfirmed())->toBeFalse();
});

it('scopes ar01 and ar02 states', function () {
    expect(Booking::factory()->ar01()->create()->group)->toBe('AR01')
        ->and(Booking::factory()->ar02()->create()->group)->toBe('AR02');
});

it('returns persons ordered by position', function () {
    $booking = Booking::factory()->create();
    Person::factory()->familyMember(2)->create(['booking_id' => $booking->id]);
    Person::factory()->lead()->create(['booking_id' => $booking->id]);

    expect($booking->persons->first()->position)->toBe(1)
        ->and($booking->persons)->toHaveCount(2);
});

it('returns lead person via hasOne', function () {
    $booking = Booking::factory()->create();
    $lead = Person::factory()->lead()->create(['booking_id' => $booking->id]);
    Person::factory()->familyMember(2)->create(['booking_id' => $booking->id]);

    expect($booking->lead->id)->toBe($lead->id);
});

it('returns payment stages ordered by stage number', function () {
    $booking = Booking::factory()->create();
    PaymentStage::create(['booking_id' => $booking->id, 'stage' => 2, 'amount_usd' => 350, 'notes' => null, 'paid_at' => null]);
    PaymentStage::create(['booking_id' => $booking->id, 'stage' => 1, 'amount_usd' => 150, 'notes' => null, 'paid_at' => null]);

    $stages = $booking->paymentStages;
    expect($stages->first()->stage)->toBe(1)
        ->and($stages->last()->stage)->toBe(2);
});

it('casts boolean fields', function () {
    $booking = Booking::factory()->create([
        'campaign_discount' => true,
        'previous_arbaeen' => false,
        'public_feed_consent' => true,
    ]);

    expect($booking->campaign_discount)->toBeTrue()
        ->and($booking->previous_arbaeen)->toBeFalse()
        ->and($booking->public_feed_consent)->toBeTrue();
});

it('enforces unique booking_id', function () {
    Booking::factory()->create(['booking_id' => 'AR01-001']);

    expect(fn () => Booking::factory()->create(['booking_id' => 'AR01-001']))
        ->toThrow(QueryException::class);
});
