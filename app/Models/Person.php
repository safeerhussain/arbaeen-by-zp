<?php

namespace App\Models;

use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    /** @use HasFactory<PersonFactory> */
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [
        'booking_id',
        'person_id',
        'position',
        'full_name',
        'fathers_name',
        'gender',
        'date_of_birth',
        'passenger_type',
        'relationship',
        'passport_expiry',
        'passport_renewal_required',
        'passport_status',
        'mobile',
        'alternate_mobile',
        'email',
        'city',
        'wheelchair_required',
        'medical_notes',
        'price_usd',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'passport_expiry' => 'date',
        'passport_renewal_required' => 'boolean',
        'wheelchair_required' => 'boolean',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function isLead(): bool
    {
        return $this->position === 1;
    }
}
