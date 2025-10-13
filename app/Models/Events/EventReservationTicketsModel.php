<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventReservationTicketsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\EventReservationTicketsModelFactory> */
    use HasFactory;

    protected $table = 'event_reservation_tickets';

    
    protected $fillable = [
        'event_reservation_id',
        'event_ticket_type_id',
    ];
}
