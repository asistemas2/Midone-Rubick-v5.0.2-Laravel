<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criticidad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'criticidades';

    protected $fillable = [
        'nombre',
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

    /* ── Scopes ─────────────────────────────────── */

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('orden');
    }
}
