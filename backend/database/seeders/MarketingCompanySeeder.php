<?php

namespace Database\Seeders;

use App\Models\Marketings\MarketingCompaniesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketingCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        MarketingCompaniesModel::firstOrCreate([
             'name' => 'Parallel Dimensions',
             'description' => 'Explorative & Experiential Marketing',
             'contact_number' => '09111111111',
             'email' => 'paradimes@gmail.com',
        ]);
    }
}
