<?php

namespace Database\Seeders;

use App\Models\Marketings\MarketingUserTypesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketingUserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        MarketingUserTypesModel::firstOrCreate([
            'user_type' => "CEO"
        ]);
    }
}
