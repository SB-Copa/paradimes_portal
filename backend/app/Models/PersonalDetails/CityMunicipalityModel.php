<?php

namespace App\Models\PersonalDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityMunicipalityModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\PersonalDetails\CityMunicipalityModelFactory> */
    use HasFactory;

    protected $table = 'refcitymun';
}
