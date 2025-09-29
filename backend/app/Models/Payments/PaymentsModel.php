<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentsModel extends Model
{
    /** @use HasFactory<\Database\Factories\Payment\PaymentsModelFactory> */
    use HasFactory;

    protected $table = 'payments';
    
       protected $fillable = [
        'payment_method_id',
        'payment_intent_id',
        'total_amount',
        'currency_id',
        'webhook_event',
    ];

    // Optional: cast 'webhook_event' as array
    protected $casts = [
        'webhook_event' => 'array',
        'total_amount' => 'decimal:2', // ensures decimals have 2 digits
    ];
}
