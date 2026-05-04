<?php

use App\Models\Booking;
use App\Models\Document;
use App\Models\Person;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

it('creates a person via factory', function () {
    $person = Person::factory()->create();

    expect($person->id)->toBeInt()
        ->and($person->full_name)->toBeString()
        ->and($person->gender)->toBeIn(['male', 'female'])
        ->and($person->passenger_type)->toBe('adult');
});

it('lead factory state sets position 1 and no relationship', function () {
    $person = Person::factory()->lead()->create();

    expect($person->position)->toBe(1)
        ->and($person->isLead())->toBeTrue()
        ->and($person->relationship)->toBeNull();
});

it('familyMember factory state sets position and relationship', function () {
    $booking = Booking::factory()->create();
    $member = Person::factory()->familyMember(3)->create(['booking_id' => $booking->id]);

    expect($member->position)->toBe(3)
        ->and($member->isLead())->toBeFalse()
        ->and($member->relationship)->not->toBeNull()
        ->and($member->mobile)->toBeNull()
        ->and($member->email)->toBeNull();
});

it('belongs to a booking', function () {
    $booking = Booking::factory()->create();
    $person = Person::factory()->create(['booking_id' => $booking->id]);

    expect($person->booking->id)->toBe($booking->id);
});

it('has documents relationship', function () {
    $person = Person::factory()->create();
    Document::create([
        'person_id' => $person->id,
        'type' => 'passport',
        'original_filename' => 'passport.jpg',
        'stored_path' => 'documents/passport.jpg',
        'mime_type' => 'image/jpeg',
        'file_size' => 204800,
    ]);

    expect($person->documents)->toHaveCount(1)
        ->and($person->documents->first()->type)->toBe('passport');
});

it('casts dates correctly', function () {
    $person = Person::factory()->create([
        'date_of_birth' => '1985-06-15',
        'passport_expiry' => '2030-01-01',
    ]);

    expect($person->date_of_birth)->toBeInstanceOf(Carbon::class)
        ->and($person->passport_expiry)->toBeInstanceOf(Carbon::class);
});

it('casts wheelchair_required as boolean', function () {
    $person = Person::factory()->create(['wheelchair_required' => false]);

    expect($person->wheelchair_required)->toBeBool()->toBeFalse();
});

it('enforces unique person_id', function () {
    Person::factory()->create(['person_id' => 'AR01-001-01']);

    expect(fn () => Person::factory()->create(['person_id' => 'AR01-001-01']))
        ->toThrow(QueryException::class);
});

it('cascades delete from booking', function () {
    $booking = Booking::factory()->create();
    Person::factory()->lead()->create(['booking_id' => $booking->id]);

    $booking->delete();

    expect(Person::count())->toBe(0);
});
