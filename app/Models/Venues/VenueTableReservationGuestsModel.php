<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueTableReservationGuestsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venues\VenueRegisteredGuestsModelFactory> */
    use HasFactory;

    protected $table = 'venue_table_reservation_guests';

    protected $fillable = [
        'full_name',
        'age',
        'entered_datetime',
        'venue_table_reservation_id',
    ];
}
