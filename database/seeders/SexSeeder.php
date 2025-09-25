<?php

namespace Database\Seeders;

use App\Models\PersonalDetails\SexModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\map;

class SexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $sex = [
            'Male',
            'Female',
            'Non-binary',
            'Transgender',
            'Genderqueer / Genderfluid',
            'Agender',
            'Other / Prefer not to say (open category)'
        ];
        
        foreach($sex as $key => $value){
            SexModel::create([
                'sex' => $value,
            ]);
        }
        
    }
}
