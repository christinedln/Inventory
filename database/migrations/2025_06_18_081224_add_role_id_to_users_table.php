<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    public function up(): void
    {
        // Get all roles first to avoid multiple queries
        $roles = DB::table('roles')->pluck('id', 'role')->toArray();

        // Update users with corresponding role_id
        DB::table('users')->orderBy('id')->chunk(100, function ($users) use ($roles) {
            foreach ($users as $user) {
                $roleId = $roles[$user->role] ?? null;
                
                if ($roleId) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['role_id' => $roleId]);
                } else {
                    Log::warning("User ID {$user->id} has unmapped role: {$user->role}");
                }
            }
        });
    }

    public function down(): void
    {
        DB::table('users')->update(['role_id' => null]);
    }
};