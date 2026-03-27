<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoInmueble extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_inmueble';

    protected $fillable = [
        'nombre',
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

    // public function inmuebles()
    // {
    //     return $this->hasMany(Inmueble::class);
    // }
}
