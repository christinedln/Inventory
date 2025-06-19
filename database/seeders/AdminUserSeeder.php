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
        \DB::table('users')->truncate();
        User::create([
            'username' => 'admin',
            'email' => 'admin@cuffed.com',
            'password' => Hash::make('admin123'), 
            'role' => 'ADMIN'
        ]);

        User::create([
            'username' => 'admin2',
            'email' => 'admin2@cuffed.com',
            'password' => Hash::make('admin123'),
            'role' => 'ADMIN'
        ]);

        User::create([
            'username' => 'admin3',
            'email' => 'admin3@cuffed.com',
            'password' => Hash::make('admin123'), 
            'role' => 'ADMIN'
        ]);
    }
}
