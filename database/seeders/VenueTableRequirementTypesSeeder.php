<?php

namespace Database\Seeders;

use App\Models\Venues\VenueTableRequirementTypesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VenueTableRequirementTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $venue_table_requirement_types = [
            'BAR'
        ];

        foreach($venue_table_requirement_types as $key => $value){
            VenueTableRequirementTypesModel::firstOrCreate([
                'type' => $value,
            ]);
        }

    }
}
