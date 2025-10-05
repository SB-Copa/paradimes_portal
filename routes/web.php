<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/admin/login',[App\Http\Controllers\Marketings\Auth\MarketingAuthController::class,'login']);
