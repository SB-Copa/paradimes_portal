<?php

namespace Database\Seeders;

use App\Models\Events\EventTypesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        EventTypesModel::firstOrCreate([
            'type' => 'Night'
        ]);
    }
}
