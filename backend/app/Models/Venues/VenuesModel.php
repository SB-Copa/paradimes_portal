<?php

namespace App\Models\Venues;

use App\Models\Events\EventsModel;
use App\Models\PersonalDetails\BarangayModel;
use App\Models\PersonalDetails\CityMunicipalityModel;
use App\Models\PersonalDetails\ProvinceModel;
use App\Models\PersonalDetails\RegionModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenuesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venue\VenuesTableModelFactory> */
    use HasFactory;

    protected $table = 'venues';

    protected $fillable = [
        'name',
        'address',
        'region_id',
        'province_id',
        'municipality_id',
        'barangay_id',
        'contact_number',
        'email',
        'websites',
        'capacity',
        'user_count',
        'table_count',
        'menu_images',
        'banner_images',
        'carousel_images',
        'menu',
        'about',
        'venue_status_id'
    ];

    protected $casts = [

    ];


    public function region(){
        return $this->belongsTo(RegionModel::class,'region_id','regCode');
    }

    public function province(){
        return $this->belongsTo(ProvinceModel::class,'province_id','provCode');
    }

    public function cityMunicipality(){
        return $this->belongsTo(CityMunicipalityModel::class,'province_id','citymunCode');
    }

    
    public function barangay(){
        return $this->belongsTo(BarangayModel::class,'barangay_id','brgyCode');
    }

    public function venueTables(){
        return $this->hasMany(VenueTablesModel::class,'venue_id','id');
    }

    public function venueStatus(){
        return $this->belongsTo(VenueStatusesModel::class,'venue_status_id','id');
    }

    public function events(){
        return $this->hasMany(EventsModel::class,'venue_id','id');
    }

    
    
}
