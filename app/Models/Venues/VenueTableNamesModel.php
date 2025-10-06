<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Model;

class VenueTableNamesModel extends Model
{
    //

    protected $table = 'venue_table_names';

    
    protected $fillable = [
        'name',
        'venue_id',
    ];
}
