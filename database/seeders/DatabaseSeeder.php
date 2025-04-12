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

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role_id' => '1',
            'email_verified_at' => now()
        ]);
        User::create([
            'name' => 'Users',
            'email' => 'users@gmail.com',
            'password' => Hash::make('users123'),
            'role_id' => '2',
            'email_verified_at' => now()
        ]);
    }
}