<?php

namespace App\Models\Marketings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasEvents extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Marketings\EventMarketingUsersFactory> */
    use HasFactory;

    protected $table = 'model_has_events';

    protected $fillable = [
        'model_type',
        'model_id',
        'event_id',
    ];
}
