<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Inventory Manager user
        User::create([
            'username' => 'manager',
            'email' => 'manager@inventory.com',
            'password' => Hash::make('manager123'), // Change this in production!
            'role' => 'INVENTORY MANAGER'
        ]);

         User::create([
            'username' => 'manager2',
            'email' => 'manager2@inventory.com',
            'password' => Hash::make('manager123'), // Change this in production!
            'role' => 'INVENTORY MANAGER'
        ]);

         User::create([
            'username' => 'manager3',
            'email' => 'manager3@inventory.com',
            'password' => Hash::make('manager123'), // Change this in production!
            'role' => 'INVENTORY MANAGER'
        ]);
    }
}
