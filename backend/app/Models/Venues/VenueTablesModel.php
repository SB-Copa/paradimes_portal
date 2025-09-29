<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueTablesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venue\VenueTablesModelFactory> */
    use HasFactory;

    protected $table = 'venue_tables';

    protected $fillable = [
        'venue_id',
        'capacity',
        'name',
    ];
}
