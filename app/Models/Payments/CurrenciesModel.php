<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrenciesModel extends Model
{
    //

    use HasFactory;

    protected $table = 'currencies';

    protected $fillable = [
        'currency'
    ];
}
