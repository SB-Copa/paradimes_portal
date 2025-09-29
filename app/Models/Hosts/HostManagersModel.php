<?php

namespace App\Models\Hosts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class HostManagersModel extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'host_managers';

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
