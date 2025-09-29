<?php

namespace App\Models\Marketings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MarketingOwnersModel extends Authenticatable
{
    //

    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'marketing_owners';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'sex_id',
        'suffix_id',
        'regCode',
        'provCode',
        'citymunCode',
        'brgyCode',
        'email',
        'password',
        'contact_number',
        'birthdate',
    ];


    
    protected $hidden = [
        'password',
        'remember_token',
    ];

 
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
