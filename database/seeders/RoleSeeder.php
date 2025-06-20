<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['role' => 'ADMIN', 'status' => 'Active'],
            ['role' => 'INVENTORY MANAGER', 'status' => 'Active'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}