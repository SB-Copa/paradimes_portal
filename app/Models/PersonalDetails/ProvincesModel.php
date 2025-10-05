<?php

namespace App\Models\PersonalDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvincesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\PersonalDetails\ProvinceModelFactory> */
    use HasFactory;

        protected $table = 'refprovince';

        public function citiesMunicipalities(){
            return $this->hasMany(CitiesMunicipalitiesModel::class,'provCode','provCode');
        }
}
