<?php

namespace App\Models\Marketings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsMarketingUsers extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Marketings\EventMarketingUsersFactory> */
    use HasFactory;

    protected $table = 'events_marketing_users';

    protected $fillable = [
        'marketing_user_id',
        'event_id',
        'marketing_company_id',
    ];
}
