<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'ADMIN';
    public const ROLE_INVENTORY_MANAGER = 'INVENTORY MANAGER';
    public const ROLE_USER = 'USER';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user's role is active
     */
    public function isRoleActive(): bool
    {
        $roleModel = $this->role()->first();
        return $roleModel && $roleModel->status === 'Active';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is inventory manager
     */
    public function isInventoryManager(): bool
    {
        return $this->role === self::ROLE_INVENTORY_MANAGER;
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    /**
     * Get the dashboard route for the user's role
     */
    public function getDashboardRoute(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'admin.dashboard',
            self::ROLE_INVENTORY_MANAGER => 'manager.dashboard',
            default => 'user.dashboard',
        };
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // When creating/updating a user, sync the role_id based on the role string
        static::saving(function ($user) {
            if ($user->isDirty('role')) {
                $roleId = DB::table('roles')
                    ->where('role', $user->role)
                    ->value('id');
                
                if ($roleId) {
                    $user->role_id = $roleId;
                }
            }
        });
    }

    /**
     * Get the role that owns the user
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
