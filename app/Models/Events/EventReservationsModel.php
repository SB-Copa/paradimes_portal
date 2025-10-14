<?php

namespace App\Models\Events;

use App\Models\Marketings\MarketingUsersModel;
use App\Models\User;
use App\Models\Users\NonRegisteredUsersModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventReservationsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\EventReservationsModelFactory> */
    use HasFactory;

    protected $table = 'event_reservations';

     protected $fillable = [
        'event_reservation_unique_id',
        'event_id',
        'description',
        'quantity',
        'total_amount',
        'model_type',
        'model_id',
        'is_primary'
        // 'venue_table_reservation_id'
        // 'user_id',
        // 'user_type',
        // 'venue_table_reservation_id',
        // 'promotion_id',
        // 'payment_intent_id',
        // 'host_model_id',
        // 'host_model_type',
    ];

    /**
     * Automatically generate UUID before creating
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->event_reservation_unique_id) {
                $model->event_reservation_unique_id = (string) Str::uuid();
            }
        });
    }

    public function morphToUser(){
        return $this->morphTo('user','model_type','model_id');
    }

    public function eventReservationTickets(){
        return $this->hasMany(EventReservationTicketsModel::class,'event_reservation_id','id');
    }
}
