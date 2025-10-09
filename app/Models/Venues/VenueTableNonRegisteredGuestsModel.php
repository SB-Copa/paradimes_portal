<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueTableNonRegisteredGuestsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venues\VenueNonRegisteredGuestsModelFactory> */
    use HasFactory;

    protected $table = 'venue_table_non_registered_guests';


    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix_id',
        'birthdate',
        'sex_id',
        'venue_table_reservation_id'
    ];
}
