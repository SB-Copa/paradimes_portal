<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodsModel extends Model
{
    /** @use HasFactory<\Database\Factories\Payment\PaymentMethodsModelFactory> */
    use HasFactory;

    protected $table = 'payment_methods';

    protected $fillable = [
        'billing_details',
        'payment_method_type_id'
    ];

    protected $casts = [
        'billing_details' => 'array'
    ];
}
