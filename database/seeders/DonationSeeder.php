<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users for donations
        $users = User::factory()->count(10)->create();

        // Create 4 campaigns
        $campaigns = Campaign::factory()->count(4)->create();

        // Give each campaign from 0 to 10 donations
        foreach ($campaigns as $campaign) {
            // Each campaign will get 10–20 donations
            $donationCount = rand(0, 10);

            for ($i = 0; $i < $donationCount; $i++) {
                $user = $users->random();

                Donation::factory()->create([
                    'user_id' => $user->id,
                    'campaign_id' => $campaign->id,
                ]);
            }
        }
    }
}
