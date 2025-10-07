<?php

namespace App\Http\Controllers\PurchaseTickets\Guests;

use App\Http\Controllers\Controller;
use App\Models\Events\EventNonRegisteredGuestsModel;
use App\Models\Events\EventTicketTypesModel;
use App\Models\Users\NonRegisteredUsersModel;
use App\Models\Venues\VenuesModel;
use App\Models\Venues\VenueTableNamesModel;
use App\Models\Venues\VenueTablesModel;
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

                            $totalCapacity = $venueTable->capacity * $quantity;

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
                'total_amount' => [
                    'required',
                    'decimal:0,2',
                    function($attribute, $value, $fail) use ($request){
                        dd(
                          collect($request->input('event.venue_table_reservations'))
                            ->map(function ($reservation) {
                                $venueTableID = $reservation['venue_table_id'];
                                $venueID = $reservation['venue_id'];
                                $venueTableName = $reservation['venu_table_name_id'];
                                return $venueTableID = $reservation['venue_table_id'];
                            })
                        );
                    }
                ]
            ]);



            

            if ($guest_ticket_validator->fails()) {
                return response()->json([
                    'errors' => $guest_ticket_validator->errors()
                ], 422);
            }


            $guest_data = $guest_ticket_validator->validated();
            dd($guest_data);


            NonRegisteredUsersModel::firstOrCreate(
                [

                ],
                [

                ]
            );

        }catch(Exception $ex){
            DB::rollback();
            throw $ex;
        }

        
    }
}
