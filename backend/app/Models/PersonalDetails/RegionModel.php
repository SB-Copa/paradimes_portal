<?php

namespace App\Models\PersonalDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\PersonalDetails\RegionModelFactory> */
    use HasFactory;

    protected $table = 'refregion';
    
}
