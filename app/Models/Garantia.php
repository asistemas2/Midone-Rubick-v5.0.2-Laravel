<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Garantia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'garantias';

    protected $fillable = [
        'codigo',
        'mantenimiento_id',
        'tipo_activo',
        'activo_id',
        'fecha_inicio',
        'fecha_fin',
        'proveedor',
        'terminos',
        'monto',
        'estado',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'monto' => 'decimal:2',
        'activo' => 'boolean',
    ];

    // ── Relaciones ──────────────────────────────────────────

    public function mantenimiento(): BelongsTo
    {
        return $this->belongsTo(Mantenimiento::class);
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    public function scopeVencidas($query)
    {
        return $query->where('estado', 'vencida');
    }

    public function scopeEnTramite($query)
    {
        return $query->where('estado', 'en_tramite');
    }

    public function scopeVigentes($query)
    {
        return $query->where('estado', 'activa')
                     ->where('fecha_fin', '>=', now());
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    // ── Accessors ───────────────────────────────────────────

    public function getEstaVigenteAttribute(): bool
    {
        if ($this->estado !== 'activa') {
            return false;
        }
        if (!$this->fecha_fin) {
            return false;
        }
        return $this->fecha_fin->isFuture() || $this->fecha_fin->isToday();
    }

    public function getDiasRestantesAttribute(): ?int
    {
        if (!$this->fecha_fin) {
            return null;
        }
        return (int) now()->diffInDays($this->fecha_fin, false);
    }

    public function getEstadoBadgeAttribute(): string
    {
        return match ($this->estado) {
            'activa' => '<span class="rounded-full bg-success/20 px-2 py-1 text-xs text-success">Activa</span>',
            'vencida' => '<span class="rounded-full bg-danger/20 px-2 py-1 text-xs text-danger">Vencida</span>',
            'en_tramite' => '<span class="rounded-full bg-warning/20 px-2 py-1 text-xs text-warning">En Trámite</span>',
            default => '<span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500">Desconocido</span>',
        };
    }
}
