<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventsModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\EventsModelFactory> */
    use HasFactory;

    protected $table = 'events';


       protected $fillable = [
        'event_unique_id',
        'name',
        'title',
        'description',
        'about',
        'is_recurring',
        'capacity',
        'menu_images',
        'banner_images',
        'carousel_images',
        'venue_id',
        'event_type_id',
        'event_ticket_type_id',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
        'menu_images' => 'array',
        'banner_images' => 'array',
        'carousel_images' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->event_unique_id) {
                $model->event_unique_id = (string) Str::uuid();
            }
        });
    }

}
