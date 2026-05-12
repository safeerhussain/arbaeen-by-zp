<?php

namespace App\Models;

use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'group',
        'status',
        'departure_city',
        'package_type',
        'campaign_discount',
        'zp_ref_id',
        'heard_about_us',
        'previous_arbaeen',
        'public_feed_consent',
        'notes',
        'confirmed_at',
    ];

    protected $casts = [
        'campaign_discount' => 'boolean',
        'previous_arbaeen' => 'boolean',
        'public_feed_consent' => 'boolean',
        'confirmed_at' => 'datetime',
    ];

    public function persons(): HasMany
    {
        return $this->hasMany(Person::class)->orderBy('position');
    }

    public function lead(): HasOne
    {
        return $this->hasOne(Person::class)->where('position', 1);
    }

    public function paymentStages(): HasMany
    {
        return $this->hasMany(PaymentStage::class)->orderBy('stage');
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function needsPassportRenewal(): bool
    {
        return $this->persons->contains(fn (Person $person) => $person->passport_renewal_required);
    }

    public function publicStatus(): string
    {
        if ($this->status === 'confirmed') {
            return 'Confirmed';
        }

        if ($this->status === 'cancelled') {
            return 'Cancelled';
        }

        if ($this->needsPassportRenewal()) {
            return 'PP Pending Renewal';
        }

        return 'Submitted';
    }
}
