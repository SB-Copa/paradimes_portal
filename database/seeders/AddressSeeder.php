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
            'app/address_sql/refregion.sql',
            'app/address_sql/refprovince.sql',
            'app/address_sql/refcitymun.sql',
            'app/address_sql/refbrgy.sql',
        ];

        foreach($path as $key => $value){
            $path = storage_path($value);
            $sql = file_get_contents($path);
            DB::unprepared($sql);
        }



    }
}
