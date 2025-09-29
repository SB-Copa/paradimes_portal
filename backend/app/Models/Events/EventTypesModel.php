<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTypesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Events\EventTypesModelFactory> */
    use HasFactory;

    protected $table = 'event_types';

    protected $fillable = [
        'type'
    ];
}
