<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Model;

class VenueTableNamesModel extends Model
{
    //

    protected $table = 'venue_table_names';

    
    protected $fillable = [
        'name',
        'venue_id',
    ];

    

    public function venueTables(){
        return $this->hasMany(VenueTablesModel::class,'venue_table_name_id','id');
    }

    // public function venueTableRequirements(){
    //     return $this->morphToMany(
    //         VenueTableRequirementsModel::class, // related model
    //         'model', // model_type model_id // Class: Venue Table Requirement
    //         'model_has_venue_table_requirements', // pivot table
    //         'model_id', // foreign key on pivot for this model // Class ID :1
    //         'venue_table_requirement_id' // foreign key on pivot for related model
    //     );
    // }

    public function venueTableRequirements()
    {
        return $this->morphMany(VenueTableRequirementsModel::class, 'model');
    }
}
