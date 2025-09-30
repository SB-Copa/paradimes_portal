<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('/login',[App\Http\Controllers\Marketing\Auth\MarketingAuthController::class,'login']);


Route::post('/add-venue',[App\Http\Controllers\Venue\VenueController::class,'store'])->middleware(['auth:marketing_users_session']);