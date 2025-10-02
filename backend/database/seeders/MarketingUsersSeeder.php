<?php

namespace Database\Seeders;

use App\Models\Marketings\MarketingCompaniesMarketingUsersModel;
use App\Models\Marketings\MarketingCompaniesModel;
use App\Models\Marketings\MarketingUsersModel;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MarketingUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

       $marketing_company = MarketingCompaniesModel::firstOrCreate([
             'name' => 'Parallel Dimensions',
             'description' => 'Explorative & Experiential Marketing',
             'contact_number' => '09111111111',
             'email' => 'paradimes@gmail.com',
        ]);

        $marketing_user = MarketingUsersModel::create([
            'first_name' => 'Juan',
            'middle_name' => 'Mendez',
            'last_name' => 'Dela Cruz',
            'suffix_id' => '1',
            'sex_id' => '1',
            'regCode' => '1',
            'provCode' => '1',
            'cityMunCode' => '1',
            'brgyCode' => '1',
            'email' => 'juandelacruz@gmail.com',
            'contact_number' => '09064826722',
            'birthdate' => '1998-10-28',
            'password' => Hash::make('admin'),
        ]);

        MarketingCompaniesMarketingUsersModel::create([
            'marketing_company_id' => $marketing_company->id,
            'marketing_user_id' => $marketing_user->id,
            'marketing_user_type_id' => 1,

        ]);

        
    }
}
