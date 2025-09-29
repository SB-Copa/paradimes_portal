<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventRegisteredGuestsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\EventRegisteredGuestsModelFactory> */
    use HasFactory;

    protected $table = 'event_registered_guests';

    
    protected $fillable = [
        'event_registered_guest_unique_id',
        'user_id',
    ];

    /**
     * Automatically generate UUID before creating
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->event_registered_guest_unique_id) {
                $model->event_registered_guest_unique_id = (string) Str::uuid();
            }
        });
    }
}
