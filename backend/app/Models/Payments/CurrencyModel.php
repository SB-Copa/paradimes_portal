<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyModel extends Model
{
    //

    use HasFactory;

    protected $table = 'currency';

    protected $fillable = [
        'currency'
    ];
}
