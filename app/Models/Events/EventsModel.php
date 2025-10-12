<?php

namespace App\Models\Events;

use App\Models\Marketings\MarketingCompaniesMarketingUsersModel;
use App\Models\Venues\VenuesModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class EventsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\EventsModelFactory> */
    use HasFactory;

    protected $table = 'events';


       protected $fillable = [
        'event_unique_id',
        'name',
        'title',
        'description',
        'about',
        'is_recurring',
        'capacity',
        'menu_images',
        'banner_images',
        'carousel_images',
        'event_type_id',
        'event_ticket_type_id',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->event_unique_id) {
                $model->event_unique_id = (string) Str::uuid();
            }
        });
    }

    public function marketingOwnerMarketingCompanies()
    {
        return $this->morphedByMany(
            MarketingCompaniesMarketingUsersModel::class,
            'model', // Class: Event
            'model_has_events',
            'event_id', // Event: 1 // Foreign key on pivot that refers to the Event
            'model_id' // Marketing na user id 1 // Foreign key on pivot that refers to the Marketing User
        );
    }

    public function eventReservation(){
        return $this->morphedByMany(
            EventReservationsModel::class,
            'model',
            'model_has_event_reservations',
            'event_reservation_id',
            'model_id'
        );

    }

    public function venues(){
        return $this->belongsToMany(VenuesModel::class,'events_venues','event_id','venue_id');
    }

    public function eventType(){
        return $this->belongsTo(EventTypesModel::class,'event_type_id','id');
    }

    public function eventTicketTypes(){
        return $this->hasMany(EventTicketTypesModel::class,'event_id','id');
    }

}
