<?php

use App\Mail\BookingConfirmedMail;
use App\Models\Booking;
use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

function validRegistrationPayload(array $overrides = []): array
{
    Storage::fake('local');

    return array_merge([
        'group' => 'AR01',
        'departure_city' => 'karachi',
        'package_type' => 'full',
        'campaign_discount' => '0',
        'heard_about_us' => 'friend',
        'previous_arbaeen' => '0',
        'public_feed_consent' => '1',
        'agree_terms' => '1',
        'persons' => [
            [
                'full_name' => 'Ali Raza',
                'fathers_name' => 'Hussain Raza',
                'gender' => 'male',
                'date_of_birth' => '1985-03-15',
                'passenger_type' => 'adult',
                'relationship' => null,
                'passport_expiry' => '2028-01-01',
                'mobile' => '03001234567',
                'alternate_mobile' => null,
                'email' => 'ali@example.com',
                'city' => 'Karachi',
                'wheelchair_required' => '0',
                'medical_notes' => null,
                'passport_scan' => UploadedFile::fake()->create('passport.jpg', 500, 'image/jpeg'),
                'passport_photo' => UploadedFile::fake()->create('photo.jpg', 200, 'image/jpeg'),
            ],
        ],
    ], $overrides);
}

it('shows the registration form', function () {
    $this->get(route('register'))->assertStatus(200)->assertSee('Register for Arbaeen');
});

it('pre-selects group from query string', function () {
    $this->get(route('register', ['group' => 'AR02']))->assertStatus(200)->assertSee('AR02');
});

it('creates a booking with lead person on valid submission', function () {
    Mail::fake();

    $response = $this->post(route('register.store'), validRegistrationPayload());

    $response->assertRedirect();

    $booking = Booking::first();
    expect($booking)->not->toBeNull()
        ->and($booking->group)->toBe('AR01')
        ->and($booking->departure_city)->toBe('karachi')
        ->and($booking->package_type)->toBe('full')
        ->and($booking->public_feed_consent)->toBeTrue();

    $lead = $booking->lead;
    expect($lead)->not->toBeNull()
        ->and($lead->full_name)->toBe('Ali Raza')
        ->and($lead->position)->toBe(1)
        ->and($lead->mobile)->toBe('03001234567')
        ->and($lead->price_usd)->toBe(1440);
});

it('generates booking_id in correct format', function () {
    Mail::fake();
    $this->post(route('register.store'), validRegistrationPayload());

    expect(Booking::first()->booking_id)->toMatch('/^AR01-\d{3}$/');
});

it('creates family member persons', function () {
    Mail::fake();

    $payload = validRegistrationPayload();
    $payload['persons'][] = [
        'full_name' => 'Fatima Raza',
        'fathers_name' => 'Hussain Raza',
        'gender' => 'female',
        'date_of_birth' => '2016-06-10',
        'passenger_type' => 'child_with_bed',
        'relationship' => 'daughter',
        'passport_expiry' => '2028-01-01',
        'passport_scan' => UploadedFile::fake()->create('passport2.jpg', 500, 'image/jpeg'),
        'passport_photo' => UploadedFile::fake()->create('photo2.jpg', 200, 'image/jpeg'),
    ];

    $this->post(route('register.store'), $payload);

    expect(Person::count())->toBe(2)
        ->and(Person::where('position', 2)->first()->full_name)->toBe('Fatima Raza')
        ->and(Person::where('position', 2)->first()->price_usd)->toBe(1090);
});

it('queues confirmation email when lead has email', function () {
    Mail::fake();

    $this->post(route('register.store'), validRegistrationPayload());

    Mail::assertQueued(BookingConfirmedMail::class, function ($mail) {
        return $mail->hasTo('ali@example.com');
    });
});

it('rejects registration when lead email is missing', function () {
    Mail::fake();

    $payload = validRegistrationPayload();
    $payload['persons'][0]['email'] = '';

    $this->post(route('register.store'), $payload)
        ->assertRedirect()
        ->assertSessionHasErrors('persons.0.email');

    Mail::assertNothingQueued();
});

it('uses ground_only pricing for ground_only package', function () {
    Mail::fake();

    $payload = validRegistrationPayload(['package_type' => 'ground_only']);
    $this->post(route('register.store'), $payload);

    expect(Person::first()->price_usd)->toBe(600);
});

it('redirects to confirmed page after successful registration', function () {
    Mail::fake();

    $this->post(route('register.store'), validRegistrationPayload())
        ->assertRedirectContains('/register/confirmed/AR01-');
});

it('shows confirmed page with booking details', function () {
    Mail::fake();
    $this->post(route('register.store'), validRegistrationPayload());

    $booking = Booking::first();
    $this->get(route('register.confirmed', $booking->booking_id))
        ->assertStatus(200)
        ->assertSee($booking->booking_id)
        ->assertSee('Ali Raza');
});

it('rejects registration without terms agreement', function () {
    Mail::fake();
    $payload = validRegistrationPayload();
    $payload['agree_terms'] = '0';

    $this->post(route('register.store'), $payload)
        ->assertRedirect()
        ->assertSessionHasErrors('agree_terms');

    expect(Booking::count())->toBe(0);
});

it('rejects registration with missing required lead fields', function () {
    Mail::fake();
    $payload = validRegistrationPayload();
    $payload['persons'][0]['full_name'] = '';

    $this->post(route('register.store'), $payload)
        ->assertRedirect()
        ->assertSessionHasErrors('persons.0.full_name');
});

it('rejects invalid group', function () {
    Mail::fake();
    $payload = validRegistrationPayload(['group' => 'AR99']);

    $this->post(route('register.store'), $payload)
        ->assertRedirect()
        ->assertSessionHasErrors('group');
});

it('redirects confirmed page to register when booking not found', function () {
    $this->get(route('register.confirmed', 'AR01-999'))
        ->assertRedirect(route('register'));
});
