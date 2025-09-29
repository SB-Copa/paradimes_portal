<?php

namespace Database\Seeders;


use App\Models\PersonalDetails\SuffixModel;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuffixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $suffix = [
            'I',
            'II',
            'III',
            'IV',
            'V',
            'VI',
            'VII',
            'SR',
            'JR',
        ];


        foreach($suffix as $key => $value){
            SuffixModel::create([
                "suffix" => $value,
            ]);
        }
        
    }
}
