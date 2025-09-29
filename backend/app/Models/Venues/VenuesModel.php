<?php

namespace App\Models\Venues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenuesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Venue\VenuesTableModelFactory> */
    use HasFactory;

    protected $table = 'venues';

    protected $fillable = [
        'name',
        'address',
        'region_id',
        'province_id',
        'municipality_id',
        'barangay_id',
        'contact_number',
        'email',
        'websites',
        'capacity',
        'user_count',
        'table_count',
        'menu_images',
        'banner_images',
        'carousel_images',
        'menu',
        'about',
    ];

    protected $casts = [
        'websites' => 'array',
        'menu_images' => 'array',
        'banner_images' => 'array',
        'carousel_images' => 'array',
    ];
}
