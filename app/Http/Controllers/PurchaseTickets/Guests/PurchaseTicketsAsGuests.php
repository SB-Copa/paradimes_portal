<?php

namespace App\Http\Controllers\PurchaseTickets\Guests;

use App\Http\Controllers\Controller;
use App\Models\Events\EventNonRegisteredGuestsModel;
use App\Models\Events\EventRegisteredGuestsModel;
use App\Models\Events\EventReservationsModel;
use App\Models\Events\EventTicketTypesModel;
use App\Models\Events\ModelHasEventReservationModel;
use App\Models\Events\ModelHasEventReservationsModel;
use App\Models\User;
use App\Models\Users\NonRegisteredUsersModel;
use App\Models\Venues\ModelHasVenueTableReservations;
use App\Models\Venues\ModelHasVenueTables;
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

    public function purchaseTicketAsGuest(Request $request)
    {


        try {

            $guest_ticket_validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'middle_name' => 'nullable|string',
                'last_name' => 'required|string',
                'suffix_id' => 'nullable|exists:suffix,id',
                'sex_id' => 'nullable|exists:sex,id',
                'contact_number' =>  [
                    'nullable',
                    'regex:/^(?:\+639|639|09)\d{9}$/'
                ],
                'birthdate' => 'required|date',
                'email' => 'required|email',
                'events.*.event_id' => 'required|exists:events,id',
                'events.*.venue_table_reservations' => [

                    function ($attribute, $value, $fail) use ($request) {


                        preg_match('/events\.(\d+)\./', $attribute, $matches);
                        $index = $matches[1] ?? 0;


                        if (($request->input("events.{$index}.event_tickets") == null && count($request->input('event.event_tickets')) <= 0) && ($value != null && count($value) <= 0)) {
                            $fail('Should buy either table or ticket.');
                        }
                    }

                ],
                'events.*.venue_table_reservations.*.venue_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {

                        preg_match('/events\.(\d+)\.venue_table_reservations\.(\d+)\./', $attribute, $matches);
                        $index = $matches[1] ?? 0;
                        $index2 = $matches[2] ?? 0;


                        $eventID = $request->input("events.{$index}.event_id");

                        $exists = VenuesModel::whereHas('events', function ($query) use ($eventID, $value) {
                            $query->where('event_id', $eventID)
                                ->where('venue_id', $value);
                        })
                            ->exists();


                        if (!$exists) {
                            $fail('The selected venue does not belong to the selected event.');
                        }
                    }
                ],
                'events.*.venue_table_reservations.*.venue_table_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {

                        preg_match('/events\.(\d+)\.venue_table_reservations\.(\d+)\./', $attribute, $matches);
                        $index = $matches[1] ?? 0;
                        $index2 = $matches[2] ?? 0;


                        // Get the venue_id for this specific reservation
                        $venueID = $request->input("events.{$index}.venue_table_reservations.{$index2}.venue_id");

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
                'events.*.venue_table_reservations.*.venue_table_name_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        preg_match('/events\.(\d+)\.venue_table_reservations\.(\d+)\./', $attribute, $matches);

                        $index = $matches[1] ?? 0;
                        $index2 = $matches[2] ?? 0;



                        $venueID = $request->input("events.{$index}.venue_table_reservations.{$index2}.venue_id");
                        $venueTableID = $request->input("events.{$index}.venue_table_reservations.{$index2}.venue_table_id");

                        $exists = VenueTableNamesModel::whereHas('venueTables', function ($query) use ($venueTableID) {
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
                'events.*.venue_table_reservations.*.quantity' => [
                    'required',
                    'integer',
                ],
                'events.*.venue_table_reservations.*.description' => 'nullable|string',
                'events.*.venue_table_reservations.*.guests' => [
                    'nullable',
                    'array',
                    function ($attribute, $value, $fail) use ($request) {

                        if (isset($value)) {
                            preg_match('/events\.(\d+)\.venue_table_reservations\.(\d+)\./', $attribute, $matches);
                            $index = $matches[1] ?? 0;
                            $index2 = $matches[2] ?? 0;


                            $quantity = $request->input("events.{$index}.venue_table_reservations.{$index2}.quantity");
                            $venueTableID =  $request->input("events.{$index}.venue_table_reservations.{$index2}.venue_table_id");

                            $venueTable = VenueTablesModel::find($venueTableID);

                            $totalCapacity = $venueTable['capacity'] * $quantity;

                            if ((count($value) > $totalCapacity) || ($totalCapacity <= 0 && count($value)) > 0) {
                                $fail('The guests must not be greater than the quantity.');
                            }
                        }
                    }
                ],
                'events.*.venue_table_reservations.*.guests.*.first_name' => 'required|string',
                'events.*.venue_table_reservations.*.guests.*.middle_name' => 'nullable|string',
                'events.*.venue_table_reservations.*.guests.*.last_name' => 'required|string',
                'events.*.venue_table_reservations.*.guests.*.suffix_id' => 'required|exists:suffix,id',
                'events.*.venue_table_reservations.*.guests.*.sex_id'   => 'nullable|exists:sex,id',
                'events.*.venue_table_reservations.*.guests.*.birthdate'  => 'required|date',
                'events.*.event_tickets' => [
                    function ($attribute, $value, $fail) use ($request) {

                        preg_match('/events\.(\d+)\.event_tickets/', $attribute, $matches);
                        $index = $matches[1] ?? 0;

                        if (($request->input("events.{$index}.event_tickets") == null && count($request->input("events.{$index}.venue_table_reservations")) <= 0) && ($value == null && count($value) <= 0)) {
                            $fail('Should buy either ticket or table.');
                        }
                    }
                ],
                'events.*.event_tickets.*.event_ticket_type_id' => 'required|exists:event_ticket_types,id',
                'events.*.event_tickets.*.quantity' => 'required|integer',
                'events.*.event_tickets.*.guests' => [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) use ($request) {

                        preg_match('/events\.(\d+)\.event_tickets\.(\d+)\./', $attribute, $matches);
                        $index = $matches[1] ?? 0;
                        $index2 = $matches[2] ?? 0;



                        $ticketQuantity = $request->input("events.{$index}.event_tickets.{$index2}.quantity");
                        $ticketTypeID = $request->input("events.{$index}.event_tickets.{$index2}.event_ticket_type_id");
                        $eventID = $request->input("events.{$index}.event_tickets.{$index2}.event_id");

                        $eventTicketType = EventTicketTypesModel::where('event_id', '=', $eventID)->where('id', '=', $ticketTypeID)->first();

                        if (!isset($value) || count($value) <= 0) {
                            $fail('Should have guests.');
                        } else if (!$eventTicketType) {
                            $fail('Ticket type does not exist on this event.');
                        } else if ($ticketQuantity > $eventTicketType->available_tickets) {
                            $fail('Ticket quantity is greater than the available ticket.');
                        }
                    }
                ],
                'events.*.event_tickets.*.guests.*.first_name' => 'required|string',
                'events.*.event_tickets.*.guests.*.middle_name' => 'nullable|string',
                'events.*.event_tickets.*.guests.*.last_name' => 'required|required',
                'events.*.event_tickets.*.guests.*.suffix' => 'nullable|exists:suffix,id',
                'events.*.event_tickets.*.guests.*.contact_number' =>  [
                    'nullable',
                    'regex:/^(?:\+639|639|09)\d{9}$/'
                ],
                'events.*.event_tickets.*.guests.*.birthdate' => 'required|date',
                'events.*.event_tickets.*.guests.*.email' => 'required|email',
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
            try {

                DB::beginTransaction();


                /**
                 * 
                 * 
                 * For table reservation
                 * 
                 * 
                 */

                if (isset($guest_data['events'])) {

                     $nonRegisteredUsers = NonRegisteredUsersModel::firstOrCreate(
                        [
                            'first_name' => $guest_data['first_name'],
                            'middle_name' => $guest_data['middle_name'] ?? null,
                            'last_name' => $guest_data['last_name'],
                            'suffix_id' => $guest_data['suffix_id'],
                            'birthdate' => $guest_data['birthdate']
                        ],
                        [
                            'first_name' => $guest_data['first_name'],
                            'middle_name' => $guest_data['middle_name'] ?? null,
                            'last_name' => $guest_data['last_name'],
                            'suffix_id' => $guest_data['suffix_id'],
                            'birthdate' => $guest_data['birthdate'],
                            'sex_id' => $guest_data['sex_id'],
                            'email' => $guest_data['email'],
                        ]
                    );

                    foreach ($guest_data['events'] as $event_key => $event_value) {

                        foreach ($event_value['venue_table_reservations'] as $venue_table_reservations_key => $venue_table_reservations_value) {
                            $venueTableReservations = VenueTableReservationsModel::join('venue_tables', 'venue_table_reservations.venue_id', '=', 'venue_tables.id')
                                ->lockForUpdate()
                                ->first();

                            /**
                             * 
                             * 
                             * Add payment gateway here
                             * 
                             */

                            if ($venueTableReservations) {
                                throw new \Exception('Venue table is already reserved');
                            } else {

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

                                //put non registered users here
                        
                                ModelHasVenueTableReservations::create([
                                    'model_type' => get_class($nonRegisteredUsers),
                                    'model_id' => $nonRegisteredUsers->id,
                                    'venue_table_reservation_id' => $venueTableReservations->id
                                ]);

                                
                                //for guests

                                foreach ($venue_table_reservations_value['guests'] as $venue_guest_key => $venue_guest_value) {

                                    $user = User::where('first_name', '=', $venue_guest_value['first_name'])
                                        ->where('middle_name', '=', $venue_guest_value['middle_name'])
                                        ->where('last_name', '=', $venue_guest_value['last_name'])
                                        ->where('suffix_id', '=', $venue_guest_value['suffix_id'])
                                        ->first();


                                    if ($user || isset($user)) {
                                        $venueTableRegisteredGuest = VenueTableRegisteredGuestsModel::create([
                                            'user_id' => $user->id,
                                        ]);

                                    }else{

                                        $venueTableNonRegisteredGuest = VenueTableNonRegisteredGuestsModel::create([
                                            'first_name' => $venue_guest_value['first_name'],
                                            'middle_name' => $venue_guest_value['middle_name'] ?? null,
                                            'last_name' => $venue_guest_value['last_name'],
                                            'suffix_id' => $venue_guest_value['suffix_id'] ?? null,
                                            'sex_id' => $venue_guest_value['sex_id'] ?? null,
                                            'birthdate' => $venue_guest_value['birthdate']
                                        ]);

                                    }
                                }
                            }
                        }




                        /**
                         * 
                         * For events ticket
                         * 
                         */


                        foreach ($event_value['event_tickets'] as $event_ticket_key => $event_ticket_value) {

                            $eventTicketType = EventTicketTypesModel::where('event_id', '=', $event_ticket_value['event_id'])
                                ->where('id', $event_ticket_value['event_ticket_type_id'])
                                ->lockForUpdate()
                                ->first();

                            if (!$eventTicketType) {
                                throw new \Exception('Ticket type not found');
                            }else if ($eventTicketType['available_tickets'] < $event_ticket_value['quantity']) {
                                throw new \Exception('Not enough tickets available');
                            }

                            /**
                             * 
                             * 
                             * Add payment gateway here
                             * 
                             */



                            if ($eventTicketType['available_tickets'] > 0) {
                                // $eventTicketType->available_tickets -= $event_ticket_value['quantity'];
                                // $eventTicketType->save();
                                $eventTicketType->decrement('available_tickets', $event_ticket_value['quantity']);


                                EventReservationsModel::create([
                                    'event_id' => $event_value->id,
                                    ''
                                ]);

                                //non registered user
                                ModelHasEventReservationsModel::create([
                                    'model_type' => get_class($nonRegisteredUsers),
                                    'model_id' => $nonRegisteredUsers->id,
                                    'venue_table_reservation_id' => $venueTableReservations->id
                                ]);

                             
                                //Guests
                                if (isset($event_ticket_value['guests'])) {

                                    //Guest
                                    foreach ($event_ticket_value['guests'] as $event_key => $event_guest) {

                                        $user = User::where('first_name', '=', $event_guest['first_name'])
                                            ->where('middle_name', '=', $event_guest['middle_name'])
                                            ->where('last_name', '=', $event_guest['last_name'])
                                            ->where('suffix_id', '=', $event_guest['suffix_id'])
                                            ->first();
                                            

                                        if ($user || isset($user)) {
                                            $eventRegisteredGuest = EventRegisteredGuestsModel::create([
                                                'user_id' => $user->id
                                            ]);

                                     
                                        } else {
                                            $eventNonRegisteredGuests = EventNonRegisteredGuestsModel::firstOrCreate(
                                                [
                                                    'first_name' => $event_guest['first_name'],
                                                    'middle_name' => $event_guest['middle_name'],
                                                    'last_name' => $event_guest['last_name'],
                                                    'suffix_id' => $event_guest['suffix_id'] ?? null,
                                                    'birthdate' => $event_guest['birthdate'],
                                                ],
                                                [
                                                    'first_name' => $event_guest['first_name'],
                                                    'middle_name' => $event_guest['middle_name'],
                                                    'last_name' => $event_guest['last_name'],
                                                    'suffix_id' => $guest['suffix_id'] ?? null,
                                                    'birthdate' => $event_guest['birthdate'],
                                                    'sex_id' => $event_guest['sex_id'] ?? null,
                                                    'email' => $event_guest['email']
                                                ]
                                            );
                                        }
                                    }
                                }
                            }
                        }

                        dd(123);
                    }
                }



                DB::commit();
            } catch (Exception $ex) {
                DB::rollback();
                throw $ex;
            }
        } catch (Exception $ex) {
            DB::rollback();
            throw $ex;
        }
    }
}
