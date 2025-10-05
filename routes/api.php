<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('/login',[App\Http\Controllers\Marketing\Auth\MarketingAuthController::class,'login']);



// Route::post('/add-venue',[App\Http\Controllers\Venue\VenueController::class,'store'])->middleware(['auth:marketing_users_session']);
Route::post('/admin/add-event',[App\Http\Controllers\Marketings\Events\EventsController::class,'storeEvent']);
Route::get('/admin/event-type',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEventType']);
Route::get('/admin/event/{eventID}',[App\Http\Controllers\Marketings\Events\EventsController::class,'showEvents']);
Route::get('/admin/event/{eventID}/venue/{venueID}',[App\Http\Controllers\Marketings\Events\Eventscontroller::class,'showEventVenue']);
Route::get('/admin/event/{eventID}/venue/{venueID}/tables',[App\Http\Controllers\Marketings\Events\Eventscontroller::class,'showEventVenueTables']);


Route::get('/admin/venue/{venueID}/event/{eventID}',[App\Http\Controllers\Marketings\Events\EventsController::class,'showVenueEventsTables']);


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




