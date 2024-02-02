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
            'fullname' => 'Kees vd Spek', 
            'car' => 1, 
        ]);
        DB::table('drivers')->insert([
            'fullname' => 'Jan Schooi', 
            'car' => 2, 
        ]);


        DB::table('rides')->insert([
            'dep' => $departDateTime,
            'arrival' => $arrivalDateTime,
            'start_point' => 'Jan Kuipersweg 21',
            'end_point' => 'almastraat 13',
            'driver_id' => 1,
            'costs' => 50,
        ]);
        DB::table('rides')->insert([
            'dep' => $departDateTime,
            'arrival' => $arrivalDateTime,
            'start_point' => 'Prins Willem Allexanderstraat 81',
            'end_point' => 'Rottumerweg 8',
            'driver_id' => 1,
            'costs' => 40,
        ]);
        DB::table('rides')->insert([
            'dep' => $departDateTime,
            'arrival' => $arrivalDateTime,
            'start_point' => 'Ombocht 5',
            'end_point' => 'almastraat 22',
            'driver_id' => 2,
            'costs' => 20,
        ]);
        DB::table('rides')->insert([
            'dep' => $departDateTime,
            'arrival' => $arrivalDateTime,
            'start_point' => 'Liaukemastraat 51',
            'end_point' => 'Fleardyk 40',
            'driver_id' => 2,
            'costs' => 30,
        ]);
    }
}
