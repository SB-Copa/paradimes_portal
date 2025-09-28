<?php

namespace App\Models\Payment;

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
