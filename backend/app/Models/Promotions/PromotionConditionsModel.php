<?php

namespace App\Models\Promotions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionConditionsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Promotions\PromotionConditionsModelFactory> */
    use HasFactory;

    protected $table = 'promotion_conditions';

    protected $fillable = [
        'condition',
    ];
}
