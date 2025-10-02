<?php

namespace App\Models\Marketings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingCompaniesMarketingUsersModel extends Model
{
    /** @use HasFactory<\Database\Factories\App\Models\Marketings\MarketingCompaniesMarketingUsersModelFactory> */
    use HasFactory;

    protected $table = 'mkt_companies_mkt_users';

    protected $fillable = [
        'marketing_company_id',
        'marketing_user_id',
        'marketing_user_type_id'
    ];
}
