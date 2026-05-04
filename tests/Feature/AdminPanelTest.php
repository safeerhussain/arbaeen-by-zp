<?php

use App\Models\Booking;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function adminUser(): User
{
    return User::factory()->create([
        'email' => 'admin@test.local',
        'password' => Hash::make('secret'),
    ]);
}

it('shows the admin login page', function () {
    $this->get(route('admin.login'))->assertStatus(200)->assertSee('Sign In');
});

it('redirects unauthenticated users from dashboard to login', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
});

it('logs in with valid credentials', function () {
    adminUser();

    $this->post(route('admin.login.post'), [
        'email' => 'admin@test.local',
        'password' => 'secret',
    ])->assertRedirect(route('admin.dashboard'));
});

it('rejects invalid credentials', function () {
    adminUser();

    $this->post(route('admin.login.post'), [
        'email' => 'admin@test.local',
        'password' => 'wrong',
    ])->assertRedirect()->assertSessionHasErrors('email');
});

it('shows dashboard to authenticated admin', function () {
    $admin = adminUser();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertStatus(200)
        ->assertSee('Bookings Dashboard');
});

it('shows booking list on dashboard', function () {
    $admin = adminUser();
    $booking = Booking::factory()->create(['booking_id' => 'AR01-001']);
    Person::factory()->lead()->create(['booking_id' => $booking->id, 'full_name' => 'Test Lead']);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertStatus(200)
        ->assertSee('AR01-001')
        ->assertSee('Test Lead');
});

it('shows booking detail page', function () {
    $admin = adminUser();
    $booking = Booking::factory()->create(['booking_id' => 'AR01-002', 'group' => 'AR01']);
    Person::factory()->lead()->create(['booking_id' => $booking->id]);

    $this->actingAs($admin)
        ->get(route('admin.booking', 'AR01-002'))
        ->assertStatus(200)
        ->assertSee('AR01-002');
});

it('updates booking status', function () {
    $admin = adminUser();
    $booking = Booking::factory()->pending()->create(['booking_id' => 'AR01-003', 'group' => 'AR01']);

    $this->actingAs($admin)
        ->post(route('admin.booking.status', 'AR01-003'), ['status' => 'confirmed'])
        ->assertRedirect();

    expect($booking->fresh()->status)->toBe('confirmed')
        ->and($booking->fresh()->confirmed_at)->not->toBeNull();
});

it('marks payment stage as paid', function () {
    $admin = adminUser();
    $booking = Booking::factory()->create(['booking_id' => 'AR01-004', 'group' => 'AR01']);

    $this->actingAs($admin)
        ->post(route('admin.booking.payment.paid', ['AR01-004', 1]))
        ->assertRedirect();

    expect($booking->paymentStages)->toHaveCount(1)
        ->and($booking->paymentStages->first()->stage)->toBe(1)
        ->and($booking->paymentStages->first()->paid_at)->not->toBeNull();
});

it('logs out successfully', function () {
    $admin = adminUser();

    $this->actingAs($admin)
        ->post(route('admin.logout'))
        ->assertRedirect(route('admin.login'));

    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
});
