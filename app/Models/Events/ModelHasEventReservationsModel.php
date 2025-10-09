<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasEventReservationsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\ModelHasEventReservationModelFactory> */
    use HasFactory;

    protected $table = 'model_has_event_reservations';

    protected $fillable = [
        'model_type',
        'model_id',
        'event_reservation_id'
    ];
}
