<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property mixed $permissions
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'origin',
        'permissions'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array'
    ];

    public function setPasswordAttribute($value)
    {
        if ($value != null && $value != "")
            $this->attributes['password'] = Hash::make($value);
    }

    public function hasRole(string $role): bool
    {
        if ($this->role = "super") {
            return true;
        }
        if ($this->permissions != null) {
            return in_array($role, $this->permissions);
        }
        return false;
    }
}
