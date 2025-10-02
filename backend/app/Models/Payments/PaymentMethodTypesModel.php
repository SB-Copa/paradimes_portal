<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodTypesModel extends Model
{
    /** @use HasFactory<\Database\Factories\Payment\PaymentMethodTypeModelFactory> */
    use HasFactory;

    protected $table = 'payment_method_types';

    protected $fillable = [
        'method_type'
    ];
}
