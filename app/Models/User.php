<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, LogsActivity, HasApiTokens, Notifiable, HasRoles;

    protected $table = 'users';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'role',
        'username',
        'password',
        'user_id',
        'name',
        'email',
        'phone',
        'image',
        'gender',
        'address',
        'verification_code',
        'is_verified',
        'is_active',
        'is_parent',
        'parent_id',
        'language_id',
        'last_login',
        'device_token',
        'api_token',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'is_parent' => 'boolean',
        'parent_id' => 'integer',
        'language_id' => 'integer',
        'last_login' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('users');
    }

    /**
     * Get the name used for password-based auth (AuthManager / StudentGuard).
     * Falls back to username, then email.
     */
    public function findForPassport(string $identifier): ?self
    {
        return static::where('username', $identifier)
            ->orWhere('email', $identifier)
            ->first();
    }
}
