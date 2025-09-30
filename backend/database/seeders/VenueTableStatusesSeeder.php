<?php

namespace Database\Seeders;

use App\Models\Venues\VenueTableStatusesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VenueTableStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $venue_table_status = [
            'AVAILABLE',
            'RESERVED',
        ];

        foreach($venue_table_status as $key => $value){
            VenueTableStatusesModel::firstOrCreate([
                'table_status' => $value
            ]);
        }
    }
}
