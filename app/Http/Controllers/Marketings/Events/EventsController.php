<?php

namespace App\Http\Controllers\Marketings\Events;

use App\Http\Controllers\Controller;
use App\Models\Events\EventsModel;
use App\Models\Events\EventTicketTypesModel;
use App\Models\Events\EventTypesModel;
use App\Models\Marketings\ModelHasEvents;
use App\Models\Venues\VenuesModel;
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

            $venue_validator = Validator::make($request->venue, [
                'name' => 'required|string|unique:venues,name',
                'address' => 'nullable|string',
                'region_id' => 'required|string|exists:refregion,regCode',
                'province_id' => 'required|string|exists:refprovince,provCode',
                'municipality_id' => 'required|string|exists:refcitymun,citymunCode',
                'barangay_id' => 'required|string|exists:refbrgy,brgyCode',
                'contact_number' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
                'websites' => 'nullable|array',
                'websites.*' => 'url',
                'capacity' => 'required|integer|min:1',
                'user_count' => 'required|integer|min:0',
                'table_count' => 'required|integer|min:1',
                'venue_menu_images' => 'nullable|array',
                'venue_menu_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'venue_banner_images' => 'nullable|array',
                'banner_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'carousel_images' => 'nullable|array',
                'carousel_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'menu' => 'nullable|string',
                'about' => 'nullable|string',
                'venue_status_id' => 'required|integer|exists:venue_statuses,id',

            ]);



            if ($venue_validator->fails()) {
                return response()->json([
                    'errors' => $venue_validator->errors()
                ], 422);
            }


            $venue_data = $venue_validator->validated();
            $venue = VenuesModel::create([
                'name' => $venue_data['name'],
                'address' => $venue_data['address'] ?? null,
                'region_id' => $venue_data['region_id'],
                'province_id' => $venue_data['province_id'],
                'municipality_id' => $venue_data['municipality_id'],
                'barangay_id' => $venue_data['barangay_id'],
                'contact_number' => $venue_data['contact_number'],
                'email' => $venue_data['email'] ?? null,
                'websites' => $venue_data['websites'] ?? null, // should be JSON cast in your model
                'capacity' => $venue_data['capacity'],
                'user_count' => $venue_data['user_count'],
                'table_count' => $venue_data['table_count'],
                'menu' => $venue_data['menu'] ?? null,
                'about' => $venue_data['about'] ?? null,
                'venue_status_id' => $venue_data['venue_status_id'],
            ]);


            $venue_banners = [];

            if ($request->hasFile('banner_images') && isset($venue)) {

                foreach ($request->file('banner_images') as $image) {
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
            if ($request->hasFile('carousel_images')  && isset($venue)) {
                foreach ($request->file('carousel_images') as $image) {
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
            if ($request->hasFile('menu_images') && isset($venue)) {
                foreach ($request->file('menu_images') as $image) {
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

            $table_validator = Validator::make($request->venue, [
                'venue_tables' => 'array',
                // 'venue_tables.*.venue_id' => 'required|exists:venues,id',
                'venue_tables.*.venue_table_status_id' => 'required|exists:venue_table_statuses,id',
                'venue_tables.*.capacity' => 'required|integer|min:1',
                'venue_tables.*.name' => 'required|string',
                'venue_tables.*.venue_table_requirements' => 'nullable|array',
                'venue_tables.*.venue_table_requirements.*.name' => 'required|string',
                'venue_tables.*.venue_table_requirements.*.description' => 'nullable|string',
                'venue_tables.*.venue_table_requirements.*.venue_table_requirement_type_id' => 'required|exists:venue_table_requirement_types,id',
                'venue_tables.*.venue_table_requirements.*.quantity' => 'required|integer|min:1',
                'venue_tables.*.venue_table_requirements.*.price' => 'required|decimal:2',
            ]);


            if ($table_validator->fails()) {
                DB::rollBack();
                return response()->json([
                    'errors' => $table_validator->errors()
                ], 422);
            }



            if ($request->venue['table_count'] != count($request->venue['venue_tables'])) {
                return response()->json('Table count and venue tables mismatch.', 400);
            }


            foreach ($request->venue['venue_tables'] as $key1 => $value1) {

                $venueTables = VenueTablesModel::firstOrCreate([
                    'venue_id' => $venue->id,
                    'capacity' => $value1['capacity'],
                    'venue_table_status_id' => $value1['venue_table_status_id'],
                    'user_type' => get_class(Auth::user()),
                    'user_id' => Auth::user()->id,
                    'name' => $value1['name'],
                ]);


                /*
                 * 
                 * When venue owner can create table requirements 
                 * will focus on events can add table requirements
                 * 
                 */


                // if(!empty($value1['venue_table_requirements'])){
                //     foreach($value1['venue_table_requirements'] as $key2 => $value2){

                //         VenueTableRequirementsModel::firstOrCreate([
                //             'name' => $value2['name'],
                //             'description' => $value2['description'],
                //             'venue_table_id' => $venueTables->id,
                //             'venue_table_requirement_type_id' => $value2['venue_table_requirement_type_id'],
                //             'quantity' => $value2['quantity'],
                //             'price' => $value2['price']
                //         ]);
                //     }
                // }
            }


            /**
             * 
             * Events
             * 
             */


            $event_validator = Validator::make($request['venue']['event'], [
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
                'event_ticket_types.*.price' => 'required|decimal:2'
            ]);

            if ($event_validator->fails()) {
                return response()->json([
                    'errors' => $event_validator->errors()
                ], 422);
            }

            $event_data = $event_validator->validated();


            $event = EventsModel::create([
                'venue_id' => $venue->id,
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


            foreach ($event_data['event_ticket_types'] as $key => $value) {
                EventTicketTypesModel::create([
                    'event_id' => $event->id,
                    'name' => $value['name'],
                    'description' => $value['description'] ?? null,
                    'price' => $value['price'] 
                ]);
            }

            /**
             * 
             * Add who created the event
             * 
             */

            $modelHasEvents = ModelHasEvents::create([
                'model_type' => get_class(Auth::user()),
                'model_id' => Auth::user()->id,
                'event_id' => $event->id
            ]);


            DB::commit();

            return response()->json($venue, 201);
        } catch (Exception $e) {
            // Rollback on error
            DB::rollBack();
            // Handle the exception
            throw $e;
        }
    }


    public function showEventType()
    {
        $event_types = EventTypesModel::all();

        return response()->json($event_types, 201);
    }


     /**
     * Display the specified resource.
     */
    public function showEvents(string $id)
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
        ->get();


        return response()->json($events, 201);
    }

    public function showEventVenue(string $eventID, string $venueID)
    {
        try{

        $events = EventsModel::with([
            'venue.venueStatus',
            'venue.region',
            'venue.province',
            'venue.cityMunicipality',
            'venue.barangay',
            // 'venue.venueTables.tableStatus',
            'eventType'
        ])
        ->whereHas('venue',function($query) use ($venueID){
            $query->where('venues.id','=',$venueID);
        })
        ->where('events.id', '=', $eventID)
        ->get();


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

    public function showVenueEventsTables(string $venueID, string $eventID)
    {

        try{
            
      
        $events = EventsModel::with([
            'venue.venueStatus',
            'venue.region',
            'venue.province',
            'venue.cityMunicipality',
            'venue.barangay',
            'venue.venueTables.tableStatus',
            'eventType'
        ])
        ->whereHas('venue',function($query) use ($venueID){
            $query->where('venues.id','=',$venueID);
        })
        ->where('events.id', '=', $eventID)
        ->get();


        return response()->json($events, 201);

        }catch(Exception $e){
            throw $e;
        }

    }

    /**
     * 
     * To show corresponding table 
     * 
     * 
     */



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
