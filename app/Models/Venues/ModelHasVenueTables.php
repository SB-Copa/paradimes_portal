<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Model;

class ModelHasVenueTables extends Model
{
    //

    protected $table = 'model_has_venue_tables';

    protected $fillable = [
        'venue_table_id',
        'model_id',
        'model_type' 
    ];
}
