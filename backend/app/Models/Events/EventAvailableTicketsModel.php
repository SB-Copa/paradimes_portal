<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAvailableTicketsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\EventAvailableTicketsModelFactory> */
    use HasFactory;

    protected $table = 'event_available_tickets';

    
    protected $fillable = [
        'event_ticket_type_id',
        'available_tickets',
    ];
}
