<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Kun Faris Al-Malik',
                'email' => 'faris@gmail.com',
                'password' => 'password',
            ],
            [
                'name' => 'Averroes Rillo',
                'email' => 'veroes@gmail.com',
                'password' => 'password',
            ],
            [
                'name' => 'Dani Setiawan',
                'email' => 'dani@gmail.com',
                'password' => 'password',
            ],
            [
                'name' => 'Labib Syakir',
                'email' => 'labib@gmail.com',
                'password' => 'password',
            ],
            [
                'name' => 'Fatta Surya',
                'email' => 'surya@gmail.com',
                'password' => 'password',
            ],
        ];

        foreach ($admins as $admin) {
            User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => Hash::make($admin['password']),
            ]);
        }
    }
}
