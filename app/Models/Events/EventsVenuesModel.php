<?php

namespace App\Models\Events;

use App\Models\Venues\VenuesModel;
use Illuminate\Database\Eloquent\Model;

class EventsVenuesModel extends Model
{
    //

    protected $table = 'events_venues';

    protected $fillable = [
        'event_id',
        'venue_id'
    ];

    
}
