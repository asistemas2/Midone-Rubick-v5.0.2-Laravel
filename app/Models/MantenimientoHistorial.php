<?php
// app/Models/MantenimientoHistorial.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MantenimientoHistorial extends Model
{
    use HasFactory;

    protected $table = 'mantenimiento_historial';

    protected $fillable = [
        'mantenimiento_id',
        'estado_anterior',
        'estado_nuevo',
        'comentario',
        'costo_real',
        'user_id',
        'user_nombre',
    ];

    protected $casts = [
        'costo_real' => 'decimal:2',
    ];

    // ── Relaciones ──────────────────────────────────────────

    public function mantenimiento(): BelongsTo
    {
        return $this->belongsTo(Mantenimiento::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeRecientes($query)
    {
        return $query->orderByDesc('created_at');
    }

    // ── Accessors ───────────────────────────────────────────

    /**
     * Nombre del usuario responsable del cambio.
     * Prioriza el snapshot para que sea inmutable si el usuario se elimina.
     */
    public function getResponsableNombreAttribute(): string
    {
        return $this->user_nombre
            ?? $this->user?->full_name
            ?? 'Sistema';
    }

    /**
     * Etiqueta HTML del estado nuevo.
     */
    public function getEstadoNuevoBadgeAttribute(): string
    {
        return match ($this->estado_nuevo) {
            'programado' => '<span class="rounded-full bg-primary/20 px-2 py-1 text-xs text-primary">Programado</span>',
            'en_proceso' => '<span class="rounded-full bg-warning/20 px-2 py-1 text-xs text-warning">En Proceso</span>',
            'completado' => '<span class="rounded-full bg-success/20 px-2 py-1 text-xs text-success">Completado</span>',
            'cancelado'  => '<span class="rounded-full bg-danger/20 px-2 py-1 text-xs text-danger">Cancelado</span>',
            default      => '<span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500">Desconocido</span>',
        };
    }

    /**
     * Etiqueta HTML del estado anterior.
     */
    public function getEstadoAnteriorBadgeAttribute(): string
    {
        if (!$this->estado_anterior) {
            return '<span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500">Creación</span>';
        }

        return match ($this->estado_anterior) {
            'programado' => '<span class="rounded-full bg-primary/20 px-2 py-1 text-xs text-primary">Programado</span>',
            'en_proceso' => '<span class="rounded-full bg-warning/20 px-2 py-1 text-xs text-warning">En Proceso</span>',
            'completado' => '<span class="rounded-full bg-success/20 px-2 py-1 text-xs text-success">Completado</span>',
            'cancelado'  => '<span class="rounded-full bg-danger/20 px-2 py-1 text-xs text-danger">Cancelado</span>',
            default      => '<span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500">Desconocido</span>',
        };
    }
}