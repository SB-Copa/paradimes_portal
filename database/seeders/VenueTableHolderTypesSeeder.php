<?php

namespace Database\Seeders;

use App\Models\Venues\VenueTableHolderTypesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VenueTableHolderTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $tableHolderType = [
            'CASUAL',
            'COMPANY',
            'ORGANIZATION'
        ];

        foreach($tableHolderType as $key => $value){
            VenueTableHolderTypesModel::firstOrCreate([
                'type' => $value
            ]);
        }

  
    }
}
