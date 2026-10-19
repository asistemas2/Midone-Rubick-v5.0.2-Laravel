<?php
// app/Models/CriticidadMantenimiento.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CriticidadMantenimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'criticidades_mantenimiento';

    protected $fillable = [
        'nombre',
        'codigo',
        'nivel',
        'color_hex',
        'orden',
        'activo',
    ];

    protected $casts = [
        'nivel'  => 'integer',
        'orden'  => 'integer',
        'activo' => 'boolean',
    ];

    // ── Relaciones ──────────────────────────────────────────

    public function mantenimientos(): HasMany
    {
        return $this->hasMany(Mantenimiento::class, 'criticidad_mantenimiento_id');
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('orden');
    }

    // ── Accessors ───────────────────────────────────────────

    public function getBadgeAttribute(): string
    {
        return sprintf(
            '<span class="rounded-full px-2 py-1 text-xs" style="background-color:%s20; color:%s">%s</span>',
            $this->color_hex,
            $this->color_hex,
            $this->nombre
        );
    }
}