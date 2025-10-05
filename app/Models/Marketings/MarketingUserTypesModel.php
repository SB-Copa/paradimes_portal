<?php

namespace App\Models\Marketings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingUserTypesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Marketings\MarketingUserTypesFactory> */
    use HasFactory;

    protected $table = 'marketing_user_types';

    protected $fillable = [
        'user_type'
    ];
}
