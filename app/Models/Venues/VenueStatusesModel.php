<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueStatusesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venues\VenueStatusesModelFactory> */
    use HasFactory;

    protected $table = 'venue_statuses';


    protected $fillable = [
        'status'
    ];
}
