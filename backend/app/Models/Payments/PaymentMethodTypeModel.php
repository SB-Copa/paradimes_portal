<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodTypeModel extends Model
{
    /** @use HasFactory<\Database\Factories\Payment\PaymentMethodTypeModelFactory> */
    use HasFactory;

    protected $table = 'payment_method_type';

    protected $fillable = [
        'method_type'
    ];
}
