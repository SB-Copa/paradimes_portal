<?php

namespace App\Models\Promotions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Promotions\PromotionsModelFactory> */
    use HasFactory;

    protected $table = 'promotions';

    
    protected $fillable = [
        'name',
        'description',
        'percentage',
        'value',
        'start_date',
        'end_date',
        'promotion_type_id',
        'usage_limit',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
        'value' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}
