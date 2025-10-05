<?php

namespace App\Models\PersonalDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangaysModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\PersonalDetails\BarangayModelFactory> */
    use HasFactory;


    protected $table = 'refbrgy';
}
