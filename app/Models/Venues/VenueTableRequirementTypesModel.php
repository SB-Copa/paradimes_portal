<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueTableRequirementTypesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venues\TableRequirementTypesModelFactory> */
    use HasFactory;

    protected $table = 'venue_table_requirement_types';

    protected $fillable = [
        'type'
    ];
}
