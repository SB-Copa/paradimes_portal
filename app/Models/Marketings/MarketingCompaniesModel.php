<?php

namespace App\Models\Marketings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingCompaniesModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Marketing\MarketingCompaniesModelFactory> */
    use HasFactory;

    protected $table = 'marketing_companies';

    protected $fillable = [
        'name',
        'description',
        'about',
        'contact_number',
        'email',
    ];
}
