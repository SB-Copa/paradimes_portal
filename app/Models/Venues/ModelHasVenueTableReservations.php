<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Model;

class ModelHasVenueTableReservations extends Model
{
    //

    protected $table = 'model_has_venue_table_reservations';

    protected $fillable = [
        'venue_table_reservation_id',
        'model_id',
        'model_type' 
    ];
}
