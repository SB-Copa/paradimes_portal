<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventReservationTicketsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\EventReservationTicketsModelFactory> */
    use HasFactory;

    protected $table = 'event_reservation_tickets';


    protected $fillable = [
        'event_reservation_ticket_unique_key',
        'event_reservation_id',
        'event_ticket_type_id',
    ];

    public function eventReservationTicketGuests()
    {
        return $this->hasOne(EventReservationTicketGuests::class, 'event_reservation_ticket_id', 'id');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->event_reservation_ticket_unique_key) {
                $model->event_reservation_ticket_unique_key = (string) Str::uuid();
            }
        });
    }
}
