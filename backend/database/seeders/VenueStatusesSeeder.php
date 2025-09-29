<?php

namespace Database\Seeders;

use App\Models\Venues\VenueStatusesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VenueStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        VenueStatusesModel::firstOrCreate([
            'status' => 'OPEN'
        ]);
    }
}
