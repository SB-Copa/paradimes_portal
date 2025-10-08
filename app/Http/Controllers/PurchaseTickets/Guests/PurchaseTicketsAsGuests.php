<?php

namespace App\Http\Controllers\PurchaseTickets\Guests;

use App\Http\Controllers\Controller;
use App\Models\Events\EventNonRegisteredGuestsModel;
use App\Models\Events\EventReservationsModel;
use App\Models\Events\EventTicketTypesModel;
use App\Models\User;
use App\Models\Users\NonRegisteredUsersModel;
use App\Models\Venues\ModelHasVenueTableReservations;
use App\Models\Venues\VenuesModel;
use App\Models\Venues\VenueTableNamesModel;
use App\Models\Venues\VenueTableNonRegisteredGuestsModel;
use App\Models\Venues\VenueTableRegisteredGuestsModel;
use App\Models\Venues\VenueTableReservationsModel;
use App\Models\Venues\VenueTablesModel;
use Database\Factories\Models\Venues\VenueTableNonRegisteredGuestsModelFactory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isArray;

class PurchaseTicketsAsGuests extends Controller
{
    //
    
    public function purchaseTicketAsGuest(Request $request){


        try{
            
            $guest_ticket_validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'middle_name' => 'nullable|string',
                'last_name' => 'required|string',
                'suffix_id' => 'nullable|exists:suffix,id',
                'sex_id' => 'nullable|exists:sex,id',
                'contact_number' => 'nullable|regex:/^(09|\+639)\d{9}$/',
                'birthdate' => 'required|date',
                'email' => 'required|email',
                'event.event_id' => 'required|exists:events,id',
                'event.venue_table_reservations' => [

                    function($attribute, $value, $fail) use ($request){
                        if(($request->input('event.event_tickets') == null && count($request->input('event.event_tickets')) <= 0) && ($value != null && count($value) <= 0)){
                            $fail('Should buy either table or ticket.');
                        }
                    }

                ],
                'event.venue_table_reservations.*.venue_id' => [
                    'required',
                    function($attribute, $value, $fail) use ($request){
                          
                        preg_match('/venue_table_reservations\.(\d+)\./', $attribute, $matches);
                        $index = $matches[1] ?? 0;

                        $eventID = $request->input('event.event_id');

                        $exists = VenuesModel::whereHas('events', function($query) use ($eventID, $value) {
                            $query->where('event_id', $eventID)
                                ->where('venue_id', $value);
                        })
                        ->exists();
                        
                             
                        if (!$exists) {
                            $fail('The selected venue does not belong to the selected event.');
                        }

                    }
                ],
                'event.venue_table_reservations.*.venue_table_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {

                        preg_match('/venue_table_reservations\.(\d+)\./', $attribute, $matches);
                        $index = $matches[1] ?? 0;
                        
                        // Get the venue_id for this specific reservation
                        $venueID = $request->input("event.venue_table_reservations.{$index}.venue_id");
                        
                        // Check if venue_table belongs to the venue
                        $exists = DB::table('venue_tables')
                            ->where('id', $value)
                            ->where('venue_id', $venueID)
                            ->exists();
                        
                        if (!$exists) {
                            $fail('The selected table does not belong to the selected venue.');
                        }
                    }
                ],
                'event.venue_table_reservations.*.venue_table_name_id' => [
                    'required',
                    function($attribute, $value, $fail) use ($request){
                        preg_match('/venue_table_reservations\.(\d+)\./', $attribute, $matches);

                        $index = $matches[1] ?? 0;

                        $venueID = $request->input("event.venue_table_reservations.{$index}.venue_id");
                        $venueTableID = $request->input("event.venue_table_reservations.{$index}.venue_table_id");

                       $exists = VenueTableNamesModel::whereHas('venueTables', function($query) use ($venueTableID) {
                            $query->where('id', $venueTableID);
                        })
                        ->where('venue_id', $venueID)
                        ->where('id', $value)
                        ->exists();

                        if (!$exists) {
                            $fail('The selected table name does not belong to the selected venue or selected table.');
                        }

                    }
                ],
                'event.venue_table_reservations.*.quantity' => [
                    'required',
                    'integer',
                ],
                'event.venue_table_reservations.*.description' => 'nullable|string',
                'event.venue_table_reservations.*.guests' => [
                    'nullable',
                    'array',
                    function($attribute, $value, $fail) use ($request){

                        if(isset($value)){
                            preg_match('/venue_table_reservations\.(\d+)\./', $attribute, $matches);
                            $index = $matches[1] ?? 0;

                            $quantity = $request->input("event.venue_table_reservations.{$index}.quantity");
                            $venueTableID =  $request->input("event.venue_table_reservations.{$index}.venue_table_id");

                            $venueTable = VenueTablesModel::find($venueTableID);
                  
                            $totalCapacity = $venueTable['capacity'] * $quantity;

                            if((count($value) > $totalCapacity) || ($totalCapacity <= 0 && count($value)) > 0){
                                $fail('The guests must not be greater than the quantity.');
                            }
                        
                        }
                        
                    }
                ],
                'event.venue_table_reservations.*.guests.*.first_name' => 'required|string',
                'event.venue_table_reservations.*.guests.*.middle_name' => 'nullable|string',
                'event.venue_table_reservations.*.guests.*.last_name' => 'required|string',
                'event.venue_table_reservations.*.guests.*.suffix_id' => 'required|exists:suffix,id',
                'event.venue_table_reservations.*.guests.*.sex_id'   => 'nullable|exists:sex,id',
                'event.venue_table_reservations.*.guests.*.birthdate'  => 'required|date',
                'event.event_tickets' => [
                    function($attribute, $value, $fail) use ($request){
                        if(($request->input('event.venue_table_reservations') == null && count($request->input('event.venue_table_reservations')) <= 0) && ($value == null && count($value) <= 0)){
                            $fail('Should buy either ticket or table.');
                        }
                    }
                ],
                'event.event_tickets.*.event_ticket_type_id' => 'required|exists:event_ticket_types,id',
                'event.event_tickets.*.quantity' => 'required|integer',
                'event.event_tickets.*.guests' => [
                    'required',
                    'array',
                    function($attribute, $value, $fail) use ($request){
          
                        preg_match('/event_tickets\.(\d+)\./', $attribute, $matches);
                        $index = $matches[1] ?? 0;

                        $ticketQuantity = $request->input("event.event_tickets.{$index}.quantity");
                        $ticketTypeID = $request->input("event.event_tickets.{$index}.event_ticket_type_id");
                        $eventID = $request->input("event.event_tickets.{$index}.event_id");

                        $eventTicketType = EventTicketTypesModel::where('event_id','=',$eventID)->where('id','=',$ticketTypeID)->first();
                     
                        if(!isset($value) || count($value) <= 0){
                            $fail('Should have guests.');
                        }else if(!$eventTicketType->exists()){
                            $fail('Ticket type does not exist on this event.');
                        }else if($ticketQuantity > $eventTicketType->available_tickets){
                            $fail('Ticket quantity is greater than the available ticket.');
                        }
                    }
                ],
                'event.event_tickets.*.guests.*.first_name' => 'required|string',
                'event.event_tickets.*.guests.*.middle_name' => 'nullable|string',
                'event.event_tickets.*.guests.*.last_name' => 'required|required',
                'event.event_tickets.*.guests.*.suffix' => 'nullable|exists:suffix,id',
                'contact_number' => 'nullable|regex:/^(09|\+639)\d{9}$/',
                'birthdate' => 'required|date',
                'email' => 'required|email',
            ]);



            

            if ($guest_ticket_validator->fails()) {
                return response()->json([
                    'errors' => $guest_ticket_validator->errors()
                ], 422);
            }

            $guest_data = $guest_ticket_validator->validated();

            /**
             * 
             * Add to database
             * 
             */
            try{
                
            DB::beginTransaction();


            /**
             * 
             * 
             * For table reservation
             * 
             * 
             */

            if(isset($guest_data['event']['venue_table_reservations'])){

                foreach($guest_data['event']['venue_table_reservations'] as $venue_table_reservations_key => $venue_table_reservations_value){
          
                    $venueTableReservations = VenueTableReservationsModel::
                    join('venue_tables','venue_table_reservations.venue_id','=','venue_tables.id')
                    ->lockForUpdate()
                    ->first();

                    /**
                     * 
                     * 
                     * Add payment gateway here
                     * 
                     */

                    if($venueTableReservations){
                        throw new \Exception('Venue table is already reserved');
                    }else{
           
                        $venueTableReservations = VenueTableReservationsModel::firstOrCreate(
                            [
                                'venue_table_id' => $venue_table_reservations_value['venue_table_id'],
                                'venue_id' => $venue_table_reservations_value['venue_id'],
                            ],
                            [
                                'venue_table_id' => $venue_table_reservations_value['venue_table_id'],
                                'venue_id' => $venue_table_reservations_value['venue_id'],
                                'venue_table_holder_type_id' => $venue_table_reservations_value['venue_table_holder_type_id'],
                                'description' =>  $venue_table_reservations_value['description'] ?? null
                            ]
                        );

                        foreach($venue_table_reservations_value['guests'] as $guests_key => $guests_value){

                            $user = User::where('first_name','=',$guests_value['first_name'])
                            ->where('middle_name','=',$guests_value['middle_name'])
                            ->where('last_name','=',$guests_value['last_name'])
                            ->where('suffix_id','=',$guests_value['suffix_id'])
                            ->first();


                            if($user || isset($user)){
                                $venueTableRegisteredGuest = VenueTableRegisteredGuestsModel::create([
                                    'user_id' => $user->id
                                ]);
                    
                                ModelHasVenueTableReservations::create([
                                    'model_type' => get_class($venueTableRegisteredGuest),
                                    'model_id' => $venueTableRegisteredGuest->id,
                                    'venue_table_reservation_id'
                                ]);

                            }else{

                                $venueTableNonRegisteredGuest = VenueTableNonRegisteredGuestsModel::create([
                                    'first_name' => $guests_value['first_name'],
                                    'middle_name' => $guests_value['middle_name'] ?? null,
                                    'last_name' => $guests_value['last_name'],
                                    'suffix_id' => $guests_value['suffix_id'] ?? null,
                                    'sex_id' => $guests_value['sex_id'] ?? null,
                                    'birthdate' => $guests_value['birthdate']
                                ]);
                               
                                ModelHasVenueTableReservations::create([
                                    'model_type' => get_class($venueTableNonRegisteredGuest),
                                    'model_id' => $venueTableNonRegisteredGuest->id,
                                    'venue_table_reservation_id'
                                ]);
                            }
                            
                        }
                        
                    }

                }

            }   

            dd(123);
 
            /**
             * 
             * 
             * For event tickets
             * 
             * 
             */

            if(isset($guest_data['event']['event_tickets'])){

                foreach($guest_data['event']['event_tickets'] as $event_ticket_key => $event_ticket_value){

                    $eventTicketType = EventTicketTypesModel::where('event_id','=',$event_ticket_value['event_id'])->where('id', $event_ticket_value['ticket_type_id'])->lockForUpdate()->get();
         
                    if(!$eventTicketType){
                        DB::rollback();
                        throw new \Exception('Ticket type not found');
                    }

                    if($eventTicketType->available_tickets < $event_ticket_value['quantity']){
                        DB::rollback();
                        throw new \Exception('Not enough tickets available');
                    }

                    /**
                     * 
                     * 
                     * Add payment gateway here
                     * 
                     */

                    if($eventTicketType->available_tickets > 0){
                        // $eventTicketType->available_tickets -= $event_ticket_value['quantity'];
                        // $eventTicketType->save();
                        $eventTicketType->decrement('available_tickets', $event_ticket_value['quantity']);
                    }

                    
                    
                    //Guests
                    if(isset($event_ticket_value['guests'])){

                        //Guest
                        foreach($event_ticket_value['guests'] as $guest){
                            $nonRegisteredUser = NonRegisteredUsersModel::firstOrCreate(
                                [
                                    'first_name' => $guest['first_name'],
                                    'middle_name' => $guest['middle_name'],
                                    'last_name' => $guest['last_name'],
                                    'suffix_id' => $guest['suffix_id'],
                                    'birthdate' => $guest['birthdate']
                                ],
                                [
                                    'first_name' => $guest['first_name'],
                                    'middle_name' => $guest['middle_name'],
                                    'last_name' => $guest['last_name'],
                                    'suffix_id' => $guest['suffix_id'],
                                    'birthdate' => $guest['birthdate'],
                                    'email' => $guest['email']
                                ]
                            );
                        }
                    }
                }
            }
            
            dd(123);

            DB::commit();

            }catch(Exception $ex){
                DB::rollback();
                throw $ex;
            }
      

        }catch(Exception $ex){
            DB::rollback();
            throw $ex;
        }

        
    }
}
