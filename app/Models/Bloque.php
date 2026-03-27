<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bloque extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bloques';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'area_m2',
        'activo',
    ];

    protected $casts = [
        'area_m2' => 'decimal:2',
        'activo'  => 'boolean',
    ];

    /* ── Scopes ─────────────────────────────────── */

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /* ── Relaciones ─────────────────────────────── */

    // Cuando exista la tabla inmuebles:
    // public function inmuebles()
    // {
    //     return $this->hasMany(Inmueble::class);
    // }
}
