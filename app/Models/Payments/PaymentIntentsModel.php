<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentIntentsModel extends Model
{
    /** @use HasFactory<\Database\Factories\Payment\PaymentIntentModelFactory> */
    use HasFactory;

    
    protected $fillable = [
        'payment_method_id',
        'total_amount',
        'currency_id',
        'statement_descriptor',
    ];

    // Optional: cast total_amount to decimal
    protected $casts = [
        'total_amount' => 'decimal:2',
    ];
}
