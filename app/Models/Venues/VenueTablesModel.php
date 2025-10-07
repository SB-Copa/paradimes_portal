<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueTablesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venue\VenueTablesModelFactory> */
    use HasFactory;

    protected $table = 'venue_tables';

    protected $fillable = [
        'venue_id',
        'user_type',
        'user_id',
        'venue_table_status_id',
        'venue_table_name_id',
        'capacity',
        'legend'
    ];

    public function venue(){
        return $this->belongsTo(VenuesModel::class,'venue_id','id');
    }

    public function tableStatus(){
        return $this->belongsTo(VenueTableStatusesModel::class,'venue_table_status_id','id');
    }
}
