<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // prepare seeders here
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(DonationSeeder::class);
    }
}
