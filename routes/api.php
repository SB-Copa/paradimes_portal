<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('/login',[App\Http\Controllers\Marketing\Auth\MarketingAuthController::class,'login']);


// Route::post('/add-venue',[App\Http\Controllers\Venue\VenueController::class,'store'])->middleware(['auth:marketing_users_session']);
Route::post('/admin/add-event',[App\Http\Controllers\Marketing\Events\EventsController::class,'storeEvent']);
Route::get('/admin/event-type',[App\Http\Controllers\Marketing\Events\EventsController::class,'showEventType']);
Route::get('/admin/event/{eventID}',[App\Http\Controllers\Marketing\Events\EventsController::class,'showEvents']);
Route::get('/admin/event/{eventID}/venue/{venueID}',[App\Http\Controllers\Marketing\Events\Eventscontroller::class,'showEventVenue']);
Route::get('/admin/event/{eventID}/venue/{venueID}/tables',[App\Http\Controllers\Marketing\Events\Eventscontroller::class,'showEventVenueTables']);


Route::get('/admin/venue/{venueID}/event/{eventID}',[App\Http\Controllers\Marketing\Events\EventsController::class,'showVenueEventsTables']);