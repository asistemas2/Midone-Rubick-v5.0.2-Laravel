<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeriodicidadMantenimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'periodicidades_mantenimiento';

    protected $fillable = [
        'nombre',
        'dias_frecuencia',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'dias_frecuencia' => 'integer',
        'activo'          => 'boolean',
    ];

    /* ── Scopes ─────────────────────────────────── */

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('dias_frecuencia');
    }
}
