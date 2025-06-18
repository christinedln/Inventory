<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin user
        User::create([
            'username' => 'admin',
            'email' => 'admin@inventory.com',
            'password' => Hash::make('admin123'), // Change this in production!
            'role' => 'ADMIN'
        ]);

        User::create([
            'username' => 'admin2',
            'email' => 'admin2@inventory.com',
            'password' => Hash::make('admin123'), // Change this in production!
            'role' => 'ADMIN'
        ]);

        User::create([
            'username' => 'admin3',
            'email' => 'admin3@inventory.com',
            'password' => Hash::make('admin123'), // Change this in production!
            'role' => 'ADMIN'
        ]);
    }
}
