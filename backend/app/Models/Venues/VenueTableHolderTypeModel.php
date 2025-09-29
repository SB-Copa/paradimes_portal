<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableHolderTypeModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venue\TableHolderTypeModelFactory> */
    use HasFactory;

    protected $table = 'venue_table_holder_type';

    protected $fillable = [
        'type'
    ];
}
