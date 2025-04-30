<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'name' => 'Group 1'
        ]);

        // Insert a specific user
        User::create([
            'username' => 'Admin_Test',
            'first_name' => 'First',
            'last_name' => 'Last',
            'email' => 'admin@admin.admin',
            'phone' => '600600600',
            'password' => bcrypt('admin'),
            'role' => 'Admin'
        ]);

        User::create([
            'username' => 'User_Test',
            'first_name' => 'User First',
            'last_name' => 'User Last',
            'email' => 'user@user.user',
            'phone' => '600600601',
            'password' => bcrypt('user'),
            'role' => 'User'
        ]);

        User::create([
            'username' => 'User_Group_1',
            'first_name' => 'User 1',
            'last_name' => 'User 1',
            'email' => 'group@group.group',
            'phone' => '600600602',
            'password' => bcrypt('user'),
            'group_id' => 1,
            'role' => 'User'
        ]);

        // Insert multiple random users
        User::factory()
            ->count(10)
            ->create();
    }
}