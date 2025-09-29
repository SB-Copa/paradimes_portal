<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VenueTableReservationModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venue\VenueTableReservationModelFactory> */
    use HasFactory;

    protected $table = 'venue_table_reservation';

     protected $fillable = [
        'venue_tables_reservation_unique_id',
        'venue_table_id',
        'venue_id',
        'user_id',
        'non_registered_user_id',
        'table_holder_type_id',
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

    // public function table()
    // {
    //     return $this->belongsTo(SectionModel::class, 'venue_table_id');
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}
