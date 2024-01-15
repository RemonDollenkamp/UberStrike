<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing records to start fresh
        DB::table('users')->truncate();

        // Insert a sample user record
        DB::table('users')->insert([
            'user-name' => 'Fdeboer1',
            'password' => Hash::make('Pass21!'),
        ]);
    }
}
