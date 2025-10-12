<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasVenueTableRequirements extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venues\ModelHasTableRequirementsFactory> */
    use HasFactory;

    protected $table = 'model_has_venue_table_requirements';

    protected $fillable  = [
        'model_type',
        'model_id',
        'venue_table_requirement_id'
    ];

    protected $hidden = [
        'model_type',
        'model_id'
    ];


    public function venueTableRequirements(){
        return $this->morphTo();
    }
}
