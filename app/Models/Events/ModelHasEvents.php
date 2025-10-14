<?php

namespace App\Models\Events;

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

    public function events(){
        return $this->morphTo();
    }
}
