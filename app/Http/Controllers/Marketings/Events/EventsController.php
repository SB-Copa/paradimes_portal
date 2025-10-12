<?php

namespace App\Http\Controllers\Marketings\Events;

use App\Http\Controllers\Controller;
use App\Models\Events\EventsModel;
use App\Models\Events\EventsVenuesModel;
use App\Models\Events\EventTicketTypesModel;
use App\Models\Events\EventTypesModel;
use App\Models\Marketings\ModelHasEvents;
use App\Models\Venues\ModelHasTableRequirements;
use App\Models\Venues\ModelHasVenueTableRequirements;
use App\Models\Venues\ModelHasVenueTables;
use App\Models\Venues\VenuesModel;
use App\Models\Venues\VenueTableNamesModel;
use App\Models\Venues\VenueTableRequirementsModel;
use App\Models\Venues\VenueTablesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeEvent(Request $request)
    {
        //
        DB::beginTransaction();

        try {

            /**
             * 
             * Venue
             * 
             */
   
            $venue_validator = Validator::make($request->venues, [
                '*.name' => 'required|string|unique:venues,name',
                '*.address' => 'nullable|string',
                '*.region_id' => 'required|string|exists:refregion,regCode',
                '*.province_id' => 'required|string|exists:refprovince,provCode',
                '*.municipality_id' => 'required|string|exists:refcitymun,citymunCode',
                '*.barangay_id' => 'required|string|exists:refbrgy,brgyCode',
                '*.contact_number' => 'required|string|max:20',
                '*.email' => 'nullable|email|max:255',
                '*.websites' => 'nullable|array',
                '*.websites.*' => 'url',
                '*.capacity' => 'required|integer|min:1',
                '*.user_count' => 'required|integer|min:0',
                '*.table_count' => 'required|integer|min:1',
                '*.venue_menu_images' => 'nullable|array',
                '*.venue_menu_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                '*.venue_banner_images' => 'nullable|array',
                '*.banner_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                '*.carousel_images' => 'nullable|array',
                '*.carousel_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                '*.menu' => 'nullable|string',
                '*.about' => 'nullable|string',
                '*.venue_status_id' => 'required|integer|exists:venue_statuses,id',

                '*.venue_tables_names' => 'array',
                // 'venue_tables.*.venue_id' => 'required|exists:venues,id',
                '*.venue_table_names.*.name' => 'required|string',
                '*.venue_table_names.*.venue_tables.*.venue_table_status_id' => 'required|exists:venue_table_statuses,id',
                '*.venue_table_names.*.venue_tables.*.capacity' => 'required|integer',
                '*.venue_table_names.*.venue_tables.*.legend' => 'required|string',
                '*.venue_table_names.*.venue_table_requirements' => 'required|array',
                '*.venue_table_names.*.venue_table_requirements.*.name' => 'required|string',
                '*.venue_table_names.*.venue_table_requirements.*.price' => 'required|decimal:2',
                '*.venue_table_names.*.venue_table_requirements.*.capacity' => 'integer|decimal:2',
                '*.venue_table_names.*.venue_table_requirements.*.description' => 'nullable|decimal:2',
                
            ]);



            if ($venue_validator->fails()) {
                return response()->json([
                    'errors' => $venue_validator->errors()
                ], 422);
            }


            $venue_data = $venue_validator->validated();

            $venues_ids = [];
            foreach($venue_data as $venue_key => $venue_value){

     
                    $venue_banners = [];
                    if($request->hasFile("venues.$venue_key.banner_images")) {

                        foreach ($request->file("venues.$venue_key.banner_images") as $image) {
                            $img = Image::read($image)
                                ->resize(1200, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })
                                ->encode(); // re-encode to clean file

                            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                            Storage::disk('private')->put('venue_banner_images/' . $filename, $img);
                            $venue_banners[] = 'venue_banner_images/' . $filename;
                        }
                    }


                    $venue_carousel_images = [];
                    if ($request->hasFile("venues.$venue_key.carousel_images")) {
                        foreach ($request->file("venues.$venue_key.carousel_images") as $image) {
                            $img = Image::read($image)
                                ->resize(1200, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })
                                ->encode(); // re-encode to clean file

                            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                            Storage::disk('private')->put('venue_carousel_images/' . $filename, $img);
                            $venue_carousel_images[] = 'venue_carousel_images/' . $filename;
                        }
                    }

                    $venue_menu_images = [];
                    if ($request->hasFile("venues.$venue_key.menu_images")) {
                        foreach ($request->file("venues.$venue_key.menu_images") as $image) {
                            $img = Image::read($image)
                                ->resize(1200, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })
                                ->encode(); // re-encode to clean file

                            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                            Storage::disk('private')->put('venue_menu_images/' . $filename, $img);
                            $venue_menu_images[] = 'venue_menu_images/' . $filename;
                        }
                    }
                
                      $venue = VenuesModel::create([
                        'name' => $venue_value['name'],
                        'address' => $venue_value['address'] ?? null,
                        'region_id' => $venue_value['region_id'],
                        'province_id' => $venue_value['province_id'],
                        'municipality_id' => $venue_value['municipality_id'],
                        'barangay_id' => $venue_value['barangay_id'],
                        'contact_number' => $venue_value['contact_number'],
                        'email' => $venue_value['email'] ?? null,
                        'websites' => $venue_value['websites'] ?? null, // should be JSON cast in your model
                        'capacity' => $venue_value['capacity'],
                        'user_count' => $venue_value['user_count'],
                        'table_count' => $venue_value['table_count'],
                        'menu' => $venue_value['menu'] ?? null,
                        'about' => $venue_value['about'] ?? null,
                        'venue_status_id' => $venue_value['venue_status_id'],

                    ]);

                 
                    //count the number of tables
                    $count_tables = 0;

                    foreach($venue_value['venue_table_names'] as $venue_table_names_key => $venue_table_names_value){
                        $count_tables+=count($venue_table_names_value['venue_tables']);
                    }
             

                    if ($venue_value['table_count'] != $count_tables) {
                        return response()->json('Table count and venue tables mismatch.', 400);
                    }

                    foreach ($venue_value['venue_table_names'] as $venue_tables_key => $venue_table_names_value) {
                  
                        $venue_table_name = VenueTableNamesModel::firstOrCreate([
                            'name' => $venue_table_names_value['name'],
                            'venue_id' => $venue->id
                        ]);


                        if(isset($venue_table_names_value['venue_table_requirements']) && !empty($venue_table_names_value['venue_table_requirements'])){
                            foreach($venue_table_names_value['venue_table_requirements'] as $venue_table_requirements_key => $venue_table_requirements_value){
                            
                                $venue_table_requirements = VenueTableRequirementsModel::create([
                                    'name' => $venue_table_requirements_value['name'],
                                    'description' => $venue_table_requirements_value['description'],
                                    'price' => $venue_table_requirements_value['price'],
                                    'capacity' => $venue_table_requirements_value['capacity'],
                                ]);

                                ModelHasVenueTableRequirements::create([
                                    'model_type' => get_class($venue_table_name),
                                    'model_id' => $venue_table_name->id,
                                    'venue_table_requirement_id' => $venue_table_requirements->id
                                ]);

                            }
                        }
                   
                        foreach($venue_table_names_value['venue_tables'] as $venue_tables_key => $venue_tables_value){
                           
                            $venueTables = VenueTablesModel::firstOrCreate([
                                'venue_table_name_id' => $venue_table_name->id,
                                'venue_id' => $venue->id,
                                'capacity' => $venue_tables_value['capacity'],
                                'venue_table_status_id' => $venue_tables_value['venue_table_status_id'],
                                // 'user_type' => get_class(Auth::user()) ?? 'App\Models\Auth\UserModel',
                                // 'user_id' => Auth::user()->id ?? '1',
                                'legend' => $venue_tables_value['legend'],
                            ]);

                  
                              
                            $modelHasVenueTables = ModelHasVenueTables::firstOrCreate([
                                'model_type' => 'App\Models\Auth\UserModel',
                                'model_id' => '1',
                                'venue_table_id' => $venueTables->id,
                            ]);

                        }

                    }

              

                $venues_ids[] = $venue->id;
            }


            /**
             * 
             * Events
             * 
             */

            $event_validator = Validator::make($request->event, [
                // 'venue_id' => 'required|exists:venues,id',
                'event_type_id' => 'required|exists:event_types,id',
                'name' => 'required|string',
                'title' => 'nullable|string',
                'description' => 'nullable|string',
                'is_recurring' => 'boolean|required',
                'capacity' => 'integer|required',
                'banner_images' => 'nullable|array',
                'banner_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'menu_images' => 'nullable|array',
                'menu_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'carousel_images' => 'nullable|array',
                'carousel_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'event_ticket_types' => 'array',
                'event_ticket_types.*.name' => 'required|string',
                'event_ticket_types.*.description' => 'nullable|string',
                'event_ticket_types.*.price' => 'required|decimal:2',
                'event_ticket_types.*.available_tickets' => 'required|integer'
            ]);

            if ($event_validator->fails()) {
                return response()->json([
                    'errors' => $event_validator->errors()
                ], 422);
            }

            $event_data = $event_validator->validated();
      
            $event_banners = [];
            if ($request->hasFile('event.banner_images')) {

                foreach ($request->file('eventbanner_images') as $image) {
                    $img = Image::read($image)
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->encode(); // re-encode to clean file

                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    Storage::disk('private')->put('event_banner_images/' . $filename, $img);
                    $event_banners[] = 'venue_banner_images/' . $filename;
                }
            }


            $venue_carousel_images = [];
            if ($request->hasFile('event.carousel_images')) {
                foreach ($request->file('event.carousel_images') as $image) {
                    $img = Image::read($image)
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->encode(); // re-encode to clean file

                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    Storage::disk('private')->put('venue_carousel_images/' . $filename, $img);
                    $venue_carousel_images[] = 'venue_carousel_images/' . $filename;
                }
            }

            $venue_menu_images = [];
            if ($request->hasFile('event.menu_images')) {
                foreach ($request->file('event.menu_images') as $image) {
                    $img = Image::read($image)
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->encode(); // re-encode to clean file

                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    Storage::disk('private')->put('venue_menu_images/' . $filename, $img);
                    $venue_menu_images[] = 'venue_menu_images/' . $filename;
                }
            }


            /**
             * 
             * Create the event
             * 
             */

            $event = EventsModel::create([
                'event_type_id' => $event_data['event_type_id'],
                'name' => $event_data['name'],
                'title' => $event_data['title'],
                'description' => $event_data['description'] ?? null,
                'is_recurring' => $event_data['is_recurring'],
                'capacity' => $event_data['capacity'],
                'banner_images' => $event_data['banner_images'] ? json_encode($event_data['banner_images']) : null,
                'menu_images' => $event_data['banner_images'] ? json_encode($event_data['menu_images']) : null,
                'carousel_images' => $event_data['carousel_images'] ? json_encode($event_data['carousel_images']) : null,
            ]);

            

            /**
             * 
             * Ticket types per event
             * 
             */
   
            foreach ($event_data['event_ticket_types'] as $key => $value) {
          
                EventTicketTypesModel::create([
                    'event_id' => $event->id,
                    'name' => $value['name'],
                    'description' => $value['description'] ?? null,
                    'price' => $value['price'], 
                    'available_tickets' => $value['available_tickets']
                ]);
            }

            /**
             * 
             * Add who created the event
             * 
             */

            $modelHasEvents = ModelHasEvents::create([
                // 'model_type' => get_class(Auth::user()),
                // 'model_id' => Auth::user()->id,
                'model_type' => 'App\Models\Auth\UserModel',
                'model_id' => '1',
                'event_id' => $event->id
            ]);
            
             /**
             * 
             * many to many for events and venues
             * 
             */

            foreach($venues_ids as $venues_ids_key => $venues_ids_value){
                     EventsVenuesModel::firstOrCreate([
                        'event_id' => $event->id,
                        'venue_id' => $venues_ids_value,
                    ]);
            }


            DB::commit();

            return response()->json($venue, 201);
        } catch (Exception $e) {
            // Rollback on error
            DB::rollBack();
            // Handle the exception
            throw $e;
        }
    }


    public function showEventTypes()
    {
        $event_types = EventTypesModel::all();

        return response()->json($event_types, 201);
    }

    public function showSpecificEventType(string $eventTypeID)
    {
        $event_types = EventTypesModel::find($eventTypeID);

        return response()->json($event_types);
    }

    public function updateEventType(Request $request, string $eventTypeID)
    {
        try{
        DB::beginTransaction();

        
        $event_types = EventTypesModel::find($eventTypeID);
        $event_types->type = $request->input('type');
        $event_types->save();    

        return response()->json('Event type updated successfully', 201);

        DB::commit();
        }catch(Exception $e){
             // Rollback on error
            DB::rollBack();
            // Handle the exception
            throw $e;
        }

    }

    public function showEvents()
    {
        $events = EventsModel::orderBy('name')->cursorPaginate(20);


        return response()->json($events);
    }


     /**
     * Display the specified resource.
     */
    public function showSpecificEvent(string $id)
    {
        //

        

        $events = EventsModel::with([
            // 'venue.venueStatus',
            // 'venue.region',
            // 'venue.province',
            // 'venue.cityMunicipality',
            // 'venue.barangay',
            // 'venue.venueTables.tableStatus',
            'eventType'
        ])
        ->where('events.id', '=', $id)
        ->first();


        return response()->json($events, 201);
    }

    public function showEventVenues(string $eventID)
    {

        try{

        $events = EventsModel::with([
            'venues.venueStatus',
            'venues.region',
            'venues.province',
            'venues.cityMunicipality',
            'venues.barangay',
            'venues.venueTableNames.venueTableRequirements',
            'venues.venueTables.tableStatus',
            'eventType'
        ])
        ->where('events.id', '=', $eventID)
        ->first();


        return response()->json($events, 201);
          
        }catch(Exception $e){
            throw $e;
        }
    }

    public function showEventSpecificVenue(string $eventID, string $venueID)
    {
        try{
         
        $events = EventsModel::with([
            'venues' => function($query) use ($venueID){
                $query->where('events_venues.venue_id','=',$venueID);
            },
            'venues.venueStatus',
            'venues.region',
            'venues.province',
            'venues.cityMunicipality',
            'venues.barangay',
            // 'venue.venueTables.tableStatus',
            'eventType'
        ])
        ->whereHas('venues',function($query) use ($venueID){
            $query->where('venues.id','=',$venueID);
        })
        ->where('events.id', '=', $eventID)
        ->first();


        return response()->json($events, 201);
          
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * 
     * Show
     * 
     */

    public function showEventVenuesTables(string $eventID, string $venueID)
    {

        try{
            
      
        $events = EventsModel::with([
            'venues' => function($query) use ($venueID){
                $query->where('events_venues.venue_id','=',$venueID);
            },
            'venues.venueStatus',
            'venues.region',
            'venues.province',
            'venues.cityMunicipality',
            'venues.barangay',
            'venues.venueTableNames.venueTableRequirements',
            'venues.venueTableNames.venueTables',
            'eventType'
        ])
        ->whereHas('venues',function($query) use ($venueID){
            $query->where('events_venues.venue_id','=',$venueID);
        })
        ->where('events.id', '=', $eventID)
        ->first();


        return response()->json($events, 201);

        }catch(Exception $e){
            throw $e;
        }

    }

    public function showEventVenuesTableNames(string $eventID, string $venueID,)
    {

        try{
            
      
        $events = EventsModel::with([
            'venues' => function($query) use ($venueID) {
                $query->where('events_venues.venue_id', '=', $venueID)
                    ->with([
                        'venueTableNames',
                        'venueStatus',
                        'region',
                        'province',
                        'cityMunicipality',
                        'barangay',
                    ]);
            },
            'eventType'
        ])
        ->whereHas('venues', function($query) use ($venueID) {
            $query->where('events_venues.venue_id', '=', $venueID);
        })
        ->where('events.id', '=', $eventID)
        ->first();



        return response()->json($events, 201);

        }catch(Exception $e){
            throw $e;
        }

    }

    public function showEventVenuesTableNamesSpecificTicketTypes(string $eventID, string $venueID, string $venueTableNameID){


        try{
            
      
        $events = EventsModel::with([
            'venues' => function($query) use ($venueID, $venueTableNameID) {
                $query->where('events_venues.venue_id', '=', $venueID)
                    ->with([
                        'venueTableNames' => function($query) use($venueTableNameID){
                            $query->where('venue_table_names.id','=', $venueTableNameID)->with([
                                'venueTableRequirements',
                                'venueTables'
                            ]);
                        },
                        'venueStatus',
                        'region',
                        'province',
                        'cityMunicipality',
                        'barangay',
                    ]);
            },
            'eventType'
        ])
        ->whereHas('venues', function($query) use ($venueID) {
            $query->where('events_venues.venue_id', '=', $venueID);
        })
        ->where('events.id', '=', $eventID)
        ->first();



        return response()->json($events, 201);

        }catch(Exception $e){
            throw $e;
        }
    }

    public function showEventVenuesTableNamesTables(string $eventID, string $venueID, string $venueTableNameID){

         try{
            
      
        $events = EventsModel::with([
            'venues' => function($query) use ($venueID, $venueTableNameID) {
                $query->where('events_venues.venue_id', '=', $venueID)
                    ->with([
                        'venueTableNames' => function($query) use($venueTableNameID){
                            $query->where('venue_table_names.id','=', $venueTableNameID)->with([
                                'venueTableRequirements',
                                'venueTables'
                            ]);
                        },
                        'venueStatus',
                        'region',
                        'province',
                        'cityMunicipality',
                        'barangay',
                    ]);
            },
            'eventType'
        ])
        ->whereHas('venues', function($query) use ($venueID) {
            $query->where('events_venues.venue_id', '=', $venueID);
        })
        ->where('events.id', '=', $eventID)
        ->first();



        return response()->json($events, 201);

        }catch(Exception $e){
            throw $e;
        }

    }

    public function showEventVenuesTableNamesSpecificTables(string $eventID, string $venueID, string $venueTableNameID, string $venueTableID)
    {

        
       
         try{
            
      
        $events = EventsModel::with([
            'venues' => function($query) use ($venueID, $venueTableNameID, $venueTableID) {
                $query->where('events_venues.venue_id', '=', $venueID)
                    ->with([
                        'venueTableNames' => function($query) use($venueTableNameID, $venueTableID){
                            $query->where('venue_table_names.id','=', $venueTableNameID)->with([
                                'venueTableRequirements',
                                'venueTables' => function($query) use ($venueTableID){
                                    $query->where('venue_tables.id','=',$venueTableID);
                                }
                            ]);
                        },
                        'venueStatus',
                        'region',
                        'province',
                        'cityMunicipality',
                        'barangay',
                    ]);
            },
            'eventType'
        ])
        ->whereHas('venues', function($query) use ($venueID) {
            $query->where('events_venues.venue_id', '=', $venueID);
        })
        ->where('events.id', '=', $eventID)
        ->first();



        return response()->json($events, 201);

        }catch(Exception $e){
            throw $e;
        }

    }


    public function showEventTicketTypes(string $eventID){

        try{

            $event_tickets = EventsModel::with([
                'eventTicketTypes'
            ])
            ->where('events.id','=',$eventID)
            ->first();

            return response()->json($event_tickets);
        }catch(Exception $e){
            throw $e;
        }
        
    }

    public function showEventSpecificTicketType(string $eventID,string $ticketTypeID){
        
         try{
           
            $event_ticket_type = EventsModel::with([
                'eventTicketTypes' => function($query) use ($ticketTypeID){
                    $query->where('event_ticket_types.id','=',$ticketTypeID);
                }
            ])
            ->where('events.id','=',$eventID)
            ->first();

            return response()->json($event_ticket_type);
        }catch(Exception $e){
            throw $e;
        }
    }

    

   
}
