<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueTableRequirementsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venues\VenueTableRequirementsFactory> */
    use HasFactory;

    protected $table = 'venue_table_requirements';

    protected $fillable = [
        'name',
        'description',
        'venue_table_id',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];
}
