<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonRegisteredUsersModel extends Model
{
    //
    use HasFactory;

    protected $table = 'non_registered_users';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix_id',
        'sex_id',
        'address',
        'region_id',
        'province_id',
        'municipality_id',
        'barangay_id',
        'contact_number',
        'birthdate',
        'email',
    ];
}
