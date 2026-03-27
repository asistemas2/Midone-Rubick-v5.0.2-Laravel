<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoEquipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estados_equipo';

    protected $fillable = [
        'nombre',
        'codigo',
        'color_hex',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /* ── Scopes ─────────────────────────────────── */

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
