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
        'price',
        'capacity'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    protected $hidden = ['pivot'];

    public function venueTableNames()
    {
        return $this->morphedByMany(
            VenueTableNamesModel::class,
            'model',
            'model_has_venue_table_requirements',
            'venue_table_requirement_id',
            'model_id'
        );
    }
}
