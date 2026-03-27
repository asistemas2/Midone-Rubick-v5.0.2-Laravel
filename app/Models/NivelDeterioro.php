<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NivelDeterioro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'niveles_deterioro';

    protected $fillable = [
        'nombre',
        'codigo',
        'color_hex',
        'orden',
        'activo',
    ];

    protected $casts = [
        'orden'  => 'integer',
        'activo' => 'boolean',
    ];

    /* ── Scopes ─────────────────────────────────── */

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('orden');
    }
}
