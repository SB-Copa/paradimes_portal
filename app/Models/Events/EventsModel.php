<?php

namespace App\Models\Events;

use App\Models\Marketings\MarketingCompaniesMarketingUsersModel;
use App\Models\Marketings\MarketingUsersModel;
use App\Models\Venues\VenuesModel;
use App\Models\Venues\VenueTableNamesModel;
use App\Models\Venues\VenueTablesModel;
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

        static::deleting(function ($pivot) {
            // When a pivot record is deleted

            $venues = EventsVenuesModel::where('event_id', '=', $pivot->id)->get();

            foreach ($venues as $key_venue => $key_value) {
                $venueTables = VenueTablesModel::where('venue_id', '=', $key_value->venue_id)->get();

                if ($venueTables) {
                    foreach ($venueTables as $venueTables_key => $venueTables_value) {

                        if ($venueTables_value->venue_table_name_id) {

                            //
                            $modelHasVenueTables = $venueTables_value->marketingUserTables()->wherePivot('model_id', '=', 1)->wherePivot('model_type', "=", "App\Models\Marketings\MarketingCompaniesMarketingUsersModel")->first();

                            $venueTableName = VenueTableNamesModel::whereHas(
                                'marketingUserTables',
                                function ($query) use ($modelHasVenueTables) {
                                    $query->where('model_type', '=', $modelHasVenueTables['pivot']['model_type'])->where('model_id', '=', $modelHasVenueTables['pivot']['model_id']);
                                }
                            )
                            ->where('id', '=', $venueTables_value->venue_table_name_id)
                            ->first();

                            if ($venueTableName) {
                                $venueTableName->venueTableRequirements()->delete();
                                $venueTableName->delete();
                            }
                        } else {
                            $venueTable = VenueTablesModel::find($venueTables_value->venue_table_id);
                            if ($venueTable) {
                                $venueTable->venueTableRequirements()->delete();
                                $venueTable->delete();
                            }
                        }
                    }
                }
            }

            EventsVenuesModel::where('event_id', '=', $pivot->id)->delete();
        });
    }




    public function modelHasEvents()
    {
        return $this->morphedByMany(
            MarketingUsersModel::class,
            'model', // Class: Event
            'model_has_events',
            'event_id', // Event: 1 // Foreign key on pivot that refers to the Event
            'model_id' // Marketing na user id 1 // Foreign key on pivot that refers to the Marketing User
        );
    }

    // public function modelHasEventReservations(){
    //     return $this->morphedByMany(
    //         EventReservationsModel::class,
    //         'model',
    //         'model_has_event_reservations',
    //         'event_reservation_id',
    //         'model_id'
    //     );

    // }

    public function venues()
    {
        return $this->belongsToMany(VenuesModel::class, 'events_venues', 'event_id', 'venue_id');
    }

    public function eventType()
    {
        return $this->belongsTo(EventTypesModel::class, 'event_type_id', 'id');
    }

    public function eventTicketTypes()
    {
        return $this->hasMany(EventTicketTypesModel::class, 'event_id', 'id');
    }

    public function eventReservations()
    {
        return $this->hasMany(EventReservationsModel::class, 'event_id', 'id');
    }
}
