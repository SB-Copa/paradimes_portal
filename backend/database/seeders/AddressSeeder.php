<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $path = [
            'app/address_sql/refRegion.sql',
            'app/address_sql/refProvince.sql',
            'app/address_sql/refCitymun.sql',
            'app/address_sql/refBrgy.sql',
        ];

        foreach($path as $key => $value){
            $path = storage_path($value);
            $sql = file_get_contents($path);
            DB::unprepared($sql);
        }



    }
}
