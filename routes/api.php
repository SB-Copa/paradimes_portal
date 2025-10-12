<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('/login',[App\Http\Controllers\Marketing\Auth\MarketingAuthController::class,'login']);

/**
 * 
 * Venue
 * 
 */

// Route::post('/add-venue',[App\Http\Controllers\Venue\VenueController::class,'store'])->middleware(['auth:marketing_users_session']);


/**
 * 
 * Event
 * 
 */

Route::post('/admin/add-events',[App\Http\Controllers\Marketings\Events\EventsController::class,'storeEvent']);

Route::get('/admin/event-types',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEventTypes']);
Route::get('/admin/event-types/{eventTypeID}',[App\Http\Controllers\Marketings\Events\EventsController::class,'showSpecificEventType']);
Route::patch('/admin/event-types/{eventTypeID}/update',[App\Http\Controllers\Marketings\Events\EventsController::class,'updateEventType']);
Route::delete('/admin/event-types/{eventTypeID}/delete',[App\Http\Controllers\Marketings\Events\EventsController::class,'deleteEventType']);
/**
 * 
 * 
 * Event venues
 * 
 */

Route::get('/admin/events',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEvents']);
Route::get('/admin/events/{eventID}',[App\Http\Controllers\Marketings\Events\EventsController::class,'showSpecificEvent']);
Route::patch('/admin/events/{eventID}/update',[App\Http\Controllers\Marketings\Events\EventsController::class,'updateSpecificEvent']);
Route::get('/admin/events/{eventID}/delete',[App\Http\Controllers\Marketings\Events\EventsController::class,'deleteSpecificEvent']);

Route::get('/admin/events/{eventID}/venues',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEventVenues']);
Route::get('/admin/events/{eventID}/venues/{venueID}',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEventSpecificVenue']);

/**
 * 
 * Event Tables
 * 
 */
Route::get('/admin/events/{eventID}/venues/{venueID}/tables',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEventVenuesTables']);
Route::get('/admin/events/{eventID}/venues/{venueID}/table-names',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEventVenuesTableNames']);
Route::get('/admin/events/{eventID}/venues/{venueID}/table-names/{tableNameID}',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEventVenuesTableNamesSpecificTicketTypes']);

Route::get('/admin/events/{eventID}/venues/{venueID}/table-names/{tableNameID}/tables',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEventVenuesTableNamesTables']);
Route::get('/admin/events/{eventID}/venues/{venueID}/table-names/{tableNameID}/tables/{tableID}',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEventVenuesTableNamesSpecificTables']);


/**
 * 
 * 
 * Event Tickets
 * 
 */

Route::get('/admin/events/{eventID}/tickets',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEventTicketTypes']);
Route::get('/admin/events/{eventID}/tickets/{ticketTypeID}',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEventSpecificTicketType']);



/**
 * 
 * Personal Attributes
 * 
 */


Route::get('/admin/personal-attributes',[App\Http\Controllers\PersonalDetails\PersonalAttributesController::class,'index']);
Route::get('/admin/sex',[App\Http\Controllers\PersonalDetails\PersonalAttributesController::class,'sex']);
Route::get('/admin/suffix',[App\Http\Controllers\PersonalDetails\PersonalAttributesController::class,'suffix']);
Route::get('/admin/regions',[App\Http\Controllers\PersonalDetails\PersonalAttributesController::class,'regions']);
Route::get('/admin/regions/{regCode}/provinces',[App\Http\Controllers\PersonalDetails\PersonalAttributesController::class,'regionsProvinces']);
Route::get('/admin/regions/{regCode}/provinces/{provCode}/cities-municipalities',[App\Http\Controllers\PersonalDetails\PersonalAttributesController::class,'regionsProvincesCitiesMunicipalities']);
Route::get('/admin/regions/{regCode}/provinces/{provCode}/cities-municipalities/{citymunCode}/barangays',[App\Http\Controllers\PersonalDetails\PersonalAttributesController::class,'regionsProvincesCitiesMunicipalitiesBarangays']);


/**
 * 
 * Purchase ticket as guest
 * 
 */

Route::post('/guest/purchase-ticket',[App\Http\Controllers\PurchaseTickets\Guests\PurchaseTicketsAsGuests::class,'purchaseTicketAsGuest']);


