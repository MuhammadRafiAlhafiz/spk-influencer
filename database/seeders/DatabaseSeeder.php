<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create();

        $users = [
            ['name' => 'admin', 'email' => 'admin@admin.com', 'role' => 'admin'],
            ['name' => 'user', 'email' => 'user@user.com', 'role' => 'users'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'password' => Hash::make('password'),
                'role' => 'user', // set manual saat seeding
            ]);
        }
    }
}