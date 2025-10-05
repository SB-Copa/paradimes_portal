<?php

namespace Database\Seeders;

use App\Models\SuffixModel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::disconnect();
        DB::reconnect();

        // Call each seeder manually
        $this->call(SuffixSeeder::class);
        $this->call(SexSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(MarketingUserTypesSeeder::class);
        $this->call(MarketingUsersSeeder::class);
        $this->call(VenueStatusesSeeder::class);
        $this->call(VenueTableStatusesSeeder::class);
        $this->call(VenueTableRequirementTypesSeeder::class);
        $this->call(EventTypesSeeder::class);
    }
}
