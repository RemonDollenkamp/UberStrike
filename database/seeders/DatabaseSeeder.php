<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $departDateTime = Carbon::now();
        $arrivalDateTime = Carbon::now()->addDays(7); // Set 'arrival' 7 days from now

        // Clear existing records to start fresh
        DB::table('users')->truncate();

        // Insert a sample user record
        DB::table('users')->insert([
            'user-name' => 'u', //Fdeboer1
            'password' => Hash::make('p'), //Pass21!
        ]);

        DB::table('drivers')->insert([
            'fullname' => 'Kees vd Spek', //Fdeboer1
            'car' => 1, 
        ]);

        // Insert a sample user record
        DB::table('rides')->insert([
            'dep' => $departDateTime,
            'arrival' => $arrivalDateTime,
            'start_point' => 'Jan Kuipersweg 21',
            'end_point' => 'almastraat 13',
            'driver_id' => 1,
            'costs' => 10,
        ]);
    }
}
