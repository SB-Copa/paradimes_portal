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

    protected static function booted()
    {
        static::deleted(function ($pivot) {
            // When a pivot record is deleted
            $event = VenuesModel::find($pivot->venue_id);

            // if ($event && $event->venues()->count() === 0) {
            //     $event->delete(); // delete parent if no venues left
            // }
        });
    }
}
