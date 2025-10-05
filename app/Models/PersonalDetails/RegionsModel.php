<?php

namespace App\Models\PersonalDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\PersonalDetails\RegionModelFactory> */
    use HasFactory;

    protected $table = 'refregion';
    
    public function provinces(){
        return $this->hasMany(ProvincesModel::class,'regCode','regCode');
    }


}
