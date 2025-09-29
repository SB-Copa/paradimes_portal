<?php

namespace App\Models\Marketings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MarketingUsersModel extends Authenticatable
{
    //

    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'marketing_users';

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
        'marketing_user_type_id'
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
