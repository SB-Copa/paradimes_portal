<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventNonRegisteredGuestsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\EventNonRegisteredGuestsModelFactory> */
    use HasFactory;

    protected $table = 'event_non_registered_guests';

    protected $fillable = [
        'event_non_registered_guest_unique_key',
        'event_reservation_ticket_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix_id',
        'sex_id',
        'address',
        'region_id',
        'province_id',
        'municipality_id',
        'barangay_id',
        'email',
        'contact_number',
        'birthdate',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    /**
     * Automatically generate UUID before creating
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->event_non_registered_guest_unique_key) {
                $model->event_non_registered_guest_unique_key = (string) Str::uuid();
            }
        });
    }
}
