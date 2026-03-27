<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaEquipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categorias_equipo';

    protected $fillable = [
        'nombre',
        'tipo_equipo_id',
        'descripcion',
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

    /* ── Relaciones ─────────────────────────────── */

    public function tipoEquipo()
    {
        return $this->belongsTo(TipoEquipo::class);
    }
}
