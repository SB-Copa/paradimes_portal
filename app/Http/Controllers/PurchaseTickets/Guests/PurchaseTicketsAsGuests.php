<?php

namespace App\Http\Controllers\PurchaseTickets\Guests;

use App\Http\Controllers\Controller;
use App\Models\Events\EventNonRegisteredGuestsModel;
use App\Models\Events\EventRegisteredGuestsModel;
use App\Models\Events\EventReservationsModel;
use App\Models\Events\EventReservationTicketGuests;
use App\Models\Events\EventReservationTicketsModel;
use App\Models\Events\EventsModel;
use App\Models\Events\EventsVenuesModel;
use App\Models\Events\EventTicketTypesModel;
use App\Models\Events\ModelHasEventReservationModel;
use App\Models\Events\ModelHasEventReservationsModel;
use App\Models\User;
use App\Models\Users\NonRegisteredUsersModel;
use App\Models\Venues\ModelHasVenueTableReservations;
use App\Models\Venues\ModelHasVenueTables;
use App\Models\Venues\VenuesModel;
use App\Models\Venues\VenueTableNamesModel;
use App\Models\Venues\VenueTableReservationGuestsModel;
use App\Models\Venues\VenueTableReservationsModel;
use App\Models\Venues\VenueTablesModel;
use Carbon\Carbon;
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
                'age' => 'nullable|integer',
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
                'events.*.venue_table_reservations.*.description' => 'nullable|string',
                'events.*.venue_table_reservations.*.is_primary' => [
                    'required',
                    'boolean',
                    function ($attribute, $value, $fail) use ($request) {
                        $venues = collect($request->input('events'))->some(function ($event) {
                            return collect($event['venue_table_reservations'])
                                ->where('is_primary', true)
                                ->count() > 1;
                        });

                        $events = collect($request->input('events'))->some(function ($event) {
                            return collect($event['event_tickets'])
                                ->where('is_primary', true)
                                ->count() > 1;
                        });

                        if ($events || $venues) {
                            $fail('There should be only one is_primary');
                        }
                    }
                ],
                'events.*.venue_table_reservations.*.guests' => [
                    'nullable',
                    'array',
                    function ($attribute, $value, $fail) use ($request) {
                         
                        if (isset($value)) {
                            preg_match('/events\.(\d+)\.venue_table_reservations\.(\d+)\./', $attribute, $matches);
                            $index = $matches[1] ?? 0;
                            $index2 = $matches[2] ?? 0;


                            $venueTableID =  $request->input("events.{$index}.venue_table_reservations.{$index2}.venue_table_id");
                            $isPrimary =  $request->input("events.{$index}.venue_table_reservations.{$index2}.is_primary");
                            $venueTable = VenueTablesModel::find($venueTableID);

                            $totalCapacity = $venueTable['capacity'];



                            if (count($value) >= $totalCapacity) {
                                $fail('The guests must not be greater than or equal the quantity.');
                            } else if (($totalCapacity <= 0 && count($value)) > 0) {
                                $fail('Capacity error');
                            } else if ($isPrimary && count($value) >= $totalCapacity - 1) {
                                $fail('Guest must be -1 if primary is included');
                            }
                        }
                    }
                ],
                'events.*.venue_table_reservations.*.guests.*.full_name' => 'nullable|string',
                'events.*.venue_table_reservations.*.guests.*.age' => 'nullable|integer',
                /**
                 * 
                 * Events Validations
                 * 
                 */
                'events.*.event_tickets' => [
                    function ($attribute, $value, $fail) use ($request) {

                        preg_match('/events\.(\d+)\.event_tickets/', $attribute, $matches);
                        $index = $matches[1] ?? 0;

                        if (($request->input("events.{$index}.event_tickets") == null && count($request->input("events.{$index}.venue_table_reservations")) <= 0) && ($value == null && count($value) <= 0)) {
                            $fail('Should buy either ticket or table.');
                        }
                    }
                ],
                'events.*.event_tickets.*.event_ticket_type_id' => [
                    'required',
                    'exists:event_ticket_types,id',
                    function ($attribute, $value, $fail) use ($request) {

                        preg_match('/events\.(\d+)\.event_tickets\.(\d+)/', $attribute, $matches);
                        $index = $matches[1] ?? 0;
                        $index2 = $matches[2] ?? 0;

                        $eventID = $request->input("events.{$index}.event_id");

                        $eventTicketTypes = EventTicketTypesModel::where('id', '=', $value)->where('event_id', '=', $eventID)->exists();

                        if (!$eventTicketTypes) {
                            $fail('Event ticket type does not exists');
                        }
                    }
                ],
                'events.*.event_tickets.*.venue_id' => [
                    'required',
                    'exists:venues,id',
                    function ($attribute, $value, $fail) use ($request) {

                        preg_match('/events\.(\d+)\.event_tickets\.(\d+)/', $attribute, $matches);
                        $index = $matches[1] ?? 0;
                        $index2 = $matches[2] ?? 0;

                        $eventID = $request->input("events.{$index}.event_id");

                        $eventsVenues = EventsVenuesModel::where('venue_id', '=', $value)->where('event_id', '=', $eventID)->exists();

                        if (!$eventsVenues) {
                            $fail('Event and venue does not match.');
                        }
                    }
                ],
                'events.*.event_tickets.*.quantity' => 'required|integer',
                'events.*.event_tickets.*.is_primary' => [
                    'required',
                    'boolean',
                    function ($attribute, $value, $fail) use ($request) {
                        $venues = collect($request->input('events'))->some(function ($event) {
                            return collect($event['venue_table_reservations'])
                                ->where('is_primary', true)
                                ->count() > 1;
                        });

                        $events = collect($request->input('events'))->some(function ($event) {
                            return collect($event['event_tickets'])
                                ->where('is_primary', true)
                                ->count() > 1;
                        });

                        if ($events || $venues) {
                            $fail('There should be only one is_primary');
                        }
                    }
                ],
                'events.*.event_tickets.*.guests' => [
                    'nullable',
                    'array',
                    function ($attribute, $value, $fail) use ($request) {

                        preg_match('/events\.(\d+)\.event_tickets\.(\d+)\./', $attribute, $matches);
                        $index = $matches[1] ?? 0;
                        $index2 = $matches[2] ?? 0;



                        $ticketQuantity = $request->input("events.{$index}.event_tickets.{$index2}.quantity");
                        $ticketTypeID = $request->input("events.{$index}.event_tickets.{$index2}.event_ticket_type_id");
                        $eventID = $request->input("events.{$index}.event_id");
                        $isPrimary = $request->input("events.{$index}.event_tickets.{$index2}.is_primary");

                        $eventTicketType = EventTicketTypesModel::where('event_id', '=', $eventID)->where('id', '=', $ticketTypeID)->first();

                        if ($ticketQuantity <= count($value)) {
                            $fail('Guest must be less than the ticket quantity.');
                        } else if (!$eventTicketType) {
                            $fail('Ticket type does not exist on this event.');
                        } else if ($ticketQuantity > $eventTicketType['available_tickets']) {
                            $fail('Ticket quantity is greater than the available ticket.');
                        } else if ($isPrimary && count($value) >= $ticketQuantity) {
                            $fail('Guest must be -1 if primary is included');
                        }
                    }
                ],
                'events.*.event_tickets.*.guests.*.full_name' => 'nullable|string',
                'events.*.event_tickets.*.guests.*.age' => 'nullable|integer',
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






                    // foreach ($guest_data['events'] as $event_key => $event_value) {

                    //     foreach ($event_value['venue_table_reservations'] as $venue_table_reservations_key => $venue_table_reservations_value) {

                    //         $venueTableReservations = VenueTableReservationsModel::join('venue_tables', 'venue_table_reservations.venue_id', '=', 'venue_tables.id')
                    //         ->where('venue_tables.id','=',$venue_table_reservations_value['venue_table_id'])
                    //         ->lockForUpdate()
                    //         ->first();

                    //         // dd($venueTableReservations);

                    //         // $venueTableReservationsLocked[] = $venueTableReservations;
                    //         /**
                    //          * 
                    //          * 
                    //          * Add payment gateway here
                    //          * 
                    //          */

                    //         if ($venueTableReservations) {
                    //             DB::rollBack();
                    //             throw new \Exception('Venue table is already reserved');
                    //         } else {


                    //             $venueTableReservations = VenueTableReservationsModel::firstOrCreate(
                    //                 [
                    //                     'venue_table_id' => $venue_table_reservations_value['venue_table_id'],
                    //                     'venue_id' => $venue_table_reservations_value['venue_id'],
                    //                 ],
                    //                 [
                    //                     'venue_table_id' => $venue_table_reservations_value['venue_table_id'],
                    //                     'venue_id' => $venue_table_reservations_value['venue_id'],
                    //                     'venue_table_holder_type_id' => $venue_table_reservations_value['venue_table_holder_type_id'],
                    //                     'description' =>  $venue_table_reservations_value['description'] ?? null
                    //                 ]
                    //             );

                    //             ModelHasVenueTableReservations::create([
                    //                 'model_type' => get_class($nonRegisteredUsers),
                    //                 'model_id' => $nonRegisteredUsers->id,
                    //                 'venue_table_reservation_id' => $venueTableReservations['id']
                    //             ]);


                    //             //for guests
                    //             if(isset($venue_table_reservations_value['guests'])){
                    //                 foreach ($venue_table_reservations_value['guests'] as $venue_guest_key => $venue_guest_value) {

                    //                     VenueTableReservationGuestsModel::create([
                    //                         'full_name' => $venue_guest_value['full_name'],
                    //                         'age' => $venue_guest_value['age'],
                    //                         'venue_table_reservation_id' =>  $venueTableReservations->id
                    //                     ]);

                    //                 }
                    //             }

                    //         }
                    //     }




                    //     /**
                    //      * 
                    //      * For events ticket
                    //      * 
                    //      */


                    //     foreach ($event_value['event_tickets'] as $event_ticket_key => $event_ticket_value) {

                    //         $eventTicketType = EventTicketTypesModel::where('event_id', '=', $event_ticket_value['event_id'])
                    //             ->where('id', $event_ticket_value['event_ticket_type_id'])
                    //             ->lockForUpdate()
                    //             ->first();

                    //         if (!$eventTicketType) {
                    //             DB::rollBack();
                    //             throw new \Exception('Ticket type not found');
                    //         } else if ($eventTicketType['available_tickets'] < $event_ticket_value['quantity']) {
                    //             DB::rollBack();
                    //             throw new \Exception('Not enough tickets available');
                    //         }

                    //         /**
                    //          * 
                    //          * 
                    //          * Add payment gateway here
                    //          * 
                    //          */



                    //         if ($eventTicketType['available_tickets'] > 0) {
                    //             // $eventTicketType->available_tickets -= $event_ticket_value['quantity'];
                    //             // $eventTicketType->save();
                    //             $eventTicketType->decrement('available_tickets', $event_ticket_value['quantity']);


                    //             $eventReservation = EventReservationsModel::create([
                    //                 'event_id' => $event_ticket_value['event_id'],
                    //             ]);


                    //             //non registered user
                    //             ModelHasEventReservationsModel::create([
                    //                 'model_type' => get_class($nonRegisteredUsers),
                    //                 'model_id' => $nonRegisteredUsers->id,
                    //                 'event_reservation_id' => $eventReservation['id']
                    //             ]);


                    //             $eventReservationTicket = EventReservationTicketsModel::create([
                    //                 'event_reservation_id' => $eventReservation['id'],
                    //                 'event_ticket_type_id' => $event_ticket_value['event_ticket_type_id'],
                    //                 'quantity' => $event_ticket_value['quantity'],
                    //             ]);


                    //             //Guests
                    //             if (isset($event_ticket_value['guests'])) {

                    //                 //Guest
                    //                 foreach ($event_ticket_value['guests'] as $event_key => $event_guest) {

                    //                     EventReservationTicketGuests::create([
                    //                        'full_name' => $event_guest['full_name'],
                    //                        'age' => $event_guest['age'],
                    //                        'event_reservation_ticket_id' => $eventReservationTicket['id']
                    //                     ]);

                    //                 }
                    //             }
                    //         }
                    //     }


                    // }

                    $maxRetries = 5;
                    $attempt = 0;

                    while ($attempt < $maxRetries) {
                        try {
                            DB::beginTransaction();

                            

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
                                    'age' =>  Carbon::parse($guest_data['age'])->age
                                ]
                            );



                            foreach ($guest_data['events'] as $event_key => $event_value) {

                                /**
                                 * VENUE TABLE RESERVATIONS
                                 */

                               
                                foreach ($event_value['venue_table_reservations'] as $venue_table_reservations_value) {

                                    // Lock the specific venue table row
                                    $venueTableReservations = VenueTableReservationsModel::join('venue_tables', 'venue_table_reservations.venue_id', '=', 'venue_tables.id')
                                        ->where('venue_table_reservations.venue_table_id', $venue_table_reservations_value['venue_table_id'])
                                        ->where('venue_table_reservations.venue_id','=',$venue_table_reservations_value['venue_id'])
                                        ->lockForUpdate()
                                        ->first();
                               
                                    // Already reserved
                                    if ($venueTableReservations) {
                                        DB::rollBack();
                                        throw new \Exception('Venue table is already reserved');
                                    }

                                    // Reserve it
                                    $venueTableReservations = VenueTableReservationsModel::firstOrCreate(
                                        [
                                            'venue_table_id' => $venue_table_reservations_value['venue_table_id'],
                                            'venue_id' => $venue_table_reservations_value['venue_id'],
                                        ],
                                        [
                                            'venue_table_id' => $venue_table_reservations_value['venue_table_id'],
                                            'venue_id' => $venue_table_reservations_value['venue_id'],
                                            'venue_table_holder_type_id' => $venue_table_reservations_value['venue_table_holder_type_id'],
                                            'description' => $venue_table_reservations_value['description'] ?? null,
                                            'model_type' => get_class($nonRegisteredUsers),
                                            'model_id' => $nonRegisteredUsers->id,
                                            'is_primary' => $venue_table_reservations_value['is_primary']
                                        ]
                                    );

                                    $venueTables = VenueTablesModel::where('venue_id','=',$venue_table_reservations_value['venue_id'])
                                    ->where('venue_tables.id','=',$venue_table_reservations_value['venue_table_id'])
                                    ->update([
                                            'venue_table_status_id' => 2,
                                    ]);

                          

                                    // ModelHasVenueTableReservations::create([
                                    //     'model_type' => get_class($nonRegisteredUsers),
                                    //     'model_id' => $nonRegisteredUsers->id,
                                    //     'venue_table_reservation_id' => $venueTableReservations['id'],
                                    // ]);

                                    // Create guests
                                    if (!empty($venue_table_reservations_value['guests'])) {
                                        foreach ($venue_table_reservations_value['guests'] as $guest) {
                                            VenueTableReservationGuestsModel::create([
                                                'full_name' => $guest['full_name'],
                                                'age' => $guest['age'],
                                                'venue_table_reservation_id' => $venueTableReservations->id,
                                            ]);
                                        }
                                    }
                                }


                                /**
                                 * EVENT TICKETS
                                 */
                                foreach ($event_value['event_tickets'] as $event_ticket_value) {

                                    $eventTicketType = EventTicketTypesModel::where('event_id', $event_value['event_id'])
                                        ->where('id', $event_ticket_value['event_ticket_type_id'])
                                        ->lockForUpdate()
                                        ->first();

                                    if (!$eventTicketType) {
                                        DB::rollBack();
                                        throw new \Exception('Ticket type not found');
                                    }

                                    if ($eventTicketType['available_tickets'] < $event_ticket_value['quantity']) {
                                        DB::rollBack();
                                        throw new \Exception('Not enough tickets available');
                                    }

                                    // Decrement available tickets
                                    $eventTicketType->decrement('available_tickets', $event_ticket_value['quantity']);

                                    // Create event reservation
                                    $eventReservation = EventReservationsModel::create([
                                        'event_id' => $event_value['event_id'],
                                        'model_type' => get_class($nonRegisteredUsers),
                                        'model_id' => $nonRegisteredUsers->id,
                                        'is_primary' => $event_ticket_value['is_primary']
                                    ]);

                                    // ModelHasEventReservationsModel::create([
                                    //     'model_type' => get_class($nonRegisteredUsers),
                                    //     'model_id' => $nonRegisteredUsers->id,
                                    //     'event_reservation_id' => $eventReservation['id'],
                                    // ]);

                                    // Reservation ticket

                                    $eventTicketCounter = 1;
                                    $eventReservationTicketID = [];

                                    while ($eventTicketCounter <= $event_ticket_value['quantity']) {
                                        $eventReservationTicket = EventReservationTicketsModel::create([
                                            'event_reservation_id' => $eventReservation['id'],
                                            'event_ticket_type_id' => $event_ticket_value['event_ticket_type_id'],
                                        ]);
                                        $eventReservationTicketID[] = $eventReservationTicket['id'];
                                        $eventTicketCounter++;
                                    }


                                    // Add ticket guests

                                    if (!empty($event_ticket_value['guests'])) {

                                        $eventReservationCounter = 0;

                                        foreach ($event_ticket_value['guests'] as $guest_key => $guest_value) {

                                            if (($event_ticket_value['is_primary'] == true) && ($eventReservationCounter + 1 >= $event_ticket_value['quantity'])) {
                                                break;
                                            }

                                            EventReservationTicketGuests::create([
                                                'full_name' => $guest_value['full_name'],
                                                'age' => $guest_value['age'],
                                                'event_reservation_ticket_id' => $eventReservationTicketID[$eventReservationCounter],
                                            ]);

                                            $eventReservationCounter++;
                                        }
                                    }
                                }
                            }
           
                            /**
                             * 💳 Payment Gateway should happen OUTSIDE the lock!
                             * Save payment intent / token only here if needed.
                             */



                            DB::commit();
                            break; // exit loop on success

                        } catch (\Illuminate\Database\QueryException $e) {
                            DB::rollBack();

                            // Handle deadlock
                            if (str_contains($e->getMessage(), 'Deadlock')) {
                                $attempt++;
                                if ($attempt >= $maxRetries) {
                                    throw new \Exception('Too many concurrent requests. Please try again later.');
                                }

                                // Wait 100ms before retrying
                                usleep(100000);
                            } else {
                                throw $e;
                            }
                        } catch (\Exception $e) {
                            DB::rollBack();
                            throw $e;
                        }
                    }

                    // dd($venueTableReservationsLocked);
                }



                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Checkout successfully.',

                ], 200);
            } catch (Exception $ex) {
                DB::rollback();
                throw $ex;
            }
        } catch (Exception $ex) {
            DB::rollback();
            throw $ex;
        }
    }

    public function showVenueEventTableReservations(string $eventID)
    {

        $venue =  EventsModel::join('events_venues', 'events.id', '=', 'events_venues.event_id')
            ->with([
                'venues.venueTableReservations.user',
                'eventReservations.user',
                'eventReservations.eventReservationTickets.eventReservationTicketGuests'
            ])
            ->where('events.id', '=', $eventID)
            ->first();

        return response()->json($venue, 200);
    }
}
