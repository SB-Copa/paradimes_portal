<?php

namespace App\Models\Promotions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionTypesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Promotions\PromotionTypesModelFactory> */
    use HasFactory;

    protected $table = 'promotion_types';

    protected $fillable = [
        'type',
        'name',
        'description',
        'promotion_condition_id',
    ];
}
