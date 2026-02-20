<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'activo',
        "proyecto_subido"
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
        "activo" => "boolean",
        "proyecto_subido" => "boolean",
    ];

    public function proyecto() {
        return $this->hasOne(Proyecto::class);
    }

    public function hasRole(string $rol): bool {
        return $this->rol === $rol;
    }
}

