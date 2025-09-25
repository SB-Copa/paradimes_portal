<?php

namespace Database\Seeders;

use App\Models\Marketing\MarketingOwnerModel;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MarketingOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        MarketingOwnerModel::create([
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
    }
}
