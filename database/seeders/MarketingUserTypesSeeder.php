<?php

namespace Database\Seeders;

use App\Models\Marketings\MarketingUserTypes;
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

        MarketingUserTypes::firstOrCreate([
            'user_type' => 'CEO'
        ]);
    }
}
