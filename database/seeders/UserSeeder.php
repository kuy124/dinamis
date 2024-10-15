<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create a new user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@chart.com',
            'password' => Hash::make('chartaja'),
        ]);
    }
}
