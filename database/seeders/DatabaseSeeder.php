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
        $departDateTime = Carbon::now()->setTime(18, 0, 0);
        $arrivalDateTime = Carbon::now()->setTime(20, 0, 0);

        // Clear existing records to start fresh
        DB::table('users')->truncate();

        //Users
        DB::table('users')->insert([
            'user-name' => 'u', //Fdeboer1
            'password' => Hash::make('p'), //Pass21!
        ]);

        //Drivers
        DB::table('drivers')->insert([
            'fullname' => 'Kees vd Spek',
            'car' => 1,
        ]);
        DB::table('drivers')->insert([
            'fullname' => 'Jan Schooi',
            'car' => 2,
        ]);

        //Rides
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

        //Workdays
        DB::table('workdays')->insert([
            'driver_id' => 1,
            'day_of_the_week' => 1,
            'shift_start' => '08:30:00',
            'shift_end' => '17:00:00',
            'status' => 1,
            'break_time' => 60
        ]);
        DB::table('workdays')->insert([
            'driver_id' => 1,
            'day_of_the_week' => 2,
            'shift_start' => '08:30:00',
            'shift_end' => '17:00:00',
            'status' => 1,
            'break_time' => 60
        ]);
        DB::table('workdays')->insert([
            'driver_id' => 1,
            'day_of_the_week' => 3,
            'shift_start' => '08:30:00',
            'shift_end' => '17:00:00',
            'status' => 1,
            'break_time' => 60
        ]);
        DB::table('workdays')->insert([
            'driver_id' => 1,
            'day_of_the_week' => 4,
            'shift_start' => '08:30:00',
            'shift_end' => '17:00:00',
            'status' => 1,
            'break_time' => 60
        ]);
        DB::table('workdays')->insert([
            'driver_id' => 1,
            'day_of_the_week' => 5,
            'shift_start' => '08:30:00',
            'shift_end' => '17:00:00',
            'status' => 1,
            'break_time' => 60
        ]);

        DB::table('workdays')->insert([
            'driver_id' => 2,
            'day_of_the_week' => 6,
            'shift_start' => '08:30:00',
            'shift_end' => '17:00:00',
            'status' => 1,
            'break_time' => 60
        ]);
        DB::table('workdays')->insert([
            'driver_id' => 2,
            'day_of_the_week' => 7,
            'shift_start' => '08:30:00',
            'shift_end' => '17:00:00',
            'status' => 1,
            'break_time' => 60
        ]);
    }
}
