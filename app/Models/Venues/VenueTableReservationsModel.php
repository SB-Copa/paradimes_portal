<?php

namespace App\Models\Venues;

use App\Models\Users\NonRegisteredUsersModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VenueTableReservationsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venue\VenueTableReservationModelFactory> */
    use HasFactory;

    protected $table = 'venue_table_reservations';

     protected $fillable = [
        'venue_tables_reservation_unique_id',
        'venue_table_id',
        'venue_id',
        'venue_table_holder_type_id',
    ];

    protected $casts = [
        'venue_tables_reservation_unique_id' => 'string',
    ];

    /**
     * Automatically generate UUID before creating
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->venue_tables_reservation_unique_id) {
                $model->venue_tables_reservation_unique_id = (string) Str::uuid();
            }
        });
    }

    // Optional: Relationships
    public function venue()
    {
        return $this->belongsTo(VenuesModel::class, 'venue_id');
    }


    public function modelHasVenueTableReservations(){
        return $this->morphedByMany(
            NonRegisteredUsersModel::class,
            'model',
            'model_has_venue_table_reservations',
            'venue_table_reservation_id', // venue table reservation id
            'model_id' // non registered id
        );
    }

    public function venueTableReservationGuests(){
        return $this->hasMany(VenueTableReservationGuestsModel::class,'venue_table_reservation_id','id');
    }

}
