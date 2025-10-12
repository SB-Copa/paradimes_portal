<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventReservationTicketGuests extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\EventRegisteredGuestsModelFactory> */
    use HasFactory;

    protected $table = 'event_reservation_ticket_guests';

    
    protected $fillable = [
        'event_registered_guest_unique_id',
        'event_reservation_ticket_id',
        'full_name',
        'age',
        'entered_datetime'
    ];





    /**
     * Automatically generate UUID before creating
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->event_registered_guest_unique_id) {
                $model->event_registered_guest_unique_id = (string) Str::uuid();
            }
        });
    }
}
