<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTicketTypesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\EventTicketTypesModelFactory> */
    use HasFactory;

    protected $table = 'event_ticket_types';

    protected $fillable = [
        'event_id',
        'ticket_type',
        'description',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

}
