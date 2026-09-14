<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles; // ← Agregar HasRoles

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'position',
        'gender', // ← AGREGAR
        'active',
        'provider',
        'provider_id',
        'avatar',
        'photo',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
    ];

    // Accessor para obtener el nombre completo
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name) ?: $this->name;
    }

    // Mutator para que 'name' se actualice automáticamente al guardar first_name/last_name
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = $value;
        $this->attributes['name'] = trim($value . ' ' . $this->last_name);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = $value;
        $this->attributes['name'] = trim($this->first_name . ' ' . $value);
    }
}
