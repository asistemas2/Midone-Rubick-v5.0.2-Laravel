<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Mantenimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mantenimientos';

    protected $fillable = [
        'codigo',
        'tipo_activo',
        'activo_id',
        'activo_type',
        'tipo_mantenimiento',
        'descripcion',
        'fecha_programada',
        'fecha_realizada',
        'responsable',
        'tipo_responsable',
        'empresa_contratista',
        'estado',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'fecha_programada' => 'date',
        'fecha_realizada' => 'date',
        'activo' => 'boolean',
    ];

    // ── Relaciones ──────────────────────────────────────────

    public function activoRelacionado(): MorphTo
    {
        return $this->morphTo('activo', 'activo_type', 'activo_id');
    }

    public function garantias(): HasMany
    {
        return $this->hasMany(Garantia::class);
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeProgramados($query)
    {
        return $query->where('estado', 'programado');
    }

    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'en_proceso');
    }

    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopeCancelados($query)
    {
        return $query->where('estado', 'cancelado');
    }

    public function scopePorTipoActivo($query, $tipo)
    {
        return $query->where('tipo_activo', $tipo);
    }

    public function scopePorTipoMantenimiento($query, $tipo)
    {
        return $query->where('tipo_mantenimiento', $tipo);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    // ── Accessors ───────────────────────────────────────────

    public function getEstadoBadgeAttribute(): string
    {
        return match ($this->estado) {
            'programado' => '<span class="rounded-full bg-primary/20 px-2 py-1 text-xs text-primary">Programado</span>',
            'en_proceso' => '<span class="rounded-full bg-warning/20 px-2 py-1 text-xs text-warning">En Proceso</span>',
            'completado' => '<span class="rounded-full bg-success/20 px-2 py-1 text-xs text-success">Completado</span>',
            'cancelado' => '<span class="rounded-full bg-danger/20 px-2 py-1 text-xs text-danger">Cancelado</span>',
            default => '<span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500">Desconocido</span>',
        };
    }

    public function getTipoMantenimientoBadgeAttribute(): string
    {
        return match ($this->tipo_mantenimiento) {
            'preventivo' => '<span class="rounded-full bg-success/20 px-2 py-1 text-xs text-success">Preventivo</span>',
            'correctivo' => '<span class="rounded-full bg-danger/20 px-2 py-1 text-xs text-danger">Correctivo</span>',
            'predictivo' => '<span class="rounded-full bg-primary/20 px-2 py-1 text-xs text-primary">Predictivo</span>',
            default => '<span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500">Desconocido</span>',
        };
    }

    public function getNombreActivoAttribute(): string
    {
        return $this->activoRelacionado?->nombre ?? 'N/A';
    }
}
