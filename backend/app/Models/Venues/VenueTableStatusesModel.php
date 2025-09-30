<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueTableStatusesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venues\VenueTableStatusModelFactory> */
    use HasFactory;

    protected $table = 'venue_table_statuses';

    protected $fillable = [
        'status',
        'start_date',
        'end_date'
    ];


}
