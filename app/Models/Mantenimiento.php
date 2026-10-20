<?php
// app/Models/Mantenimiento.php

namespace App\Models;

use App\Models\Concerns\TieneConsecutivo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Mantenimiento extends Model
{
    use HasFactory, SoftDeletes, TieneConsecutivo;

    /** Prefijo del código consecutivo (ver App\Support\Consecutivo). */
    public const PREFIJO_CODIGO = 'MT';

    protected $table = 'mantenimientos';

    protected $fillable = [
        'codigo',
        'tipo_activo',
        'activo_id',
        'activo_type',
        'tipo_mantenimiento',
        'criterio_mantenimiento',
        'criticidad_mantenimiento_id',
        'descripcion',
        'fecha_programada',
        'fecha_realizada',
        'fecha_completado',
        'responsable',
        'tipo_responsable',
        'empresa_contratista',
        'presupuesto_aprobado',
        'costo_real',
        'estado',
        'observaciones',
        'activo',
        'periodicidad_mantenimiento_id',
    ];

    protected $casts = [
        'fecha_programada'  => 'date',
        'fecha_realizada'   => 'date',
        'fecha_completado'  => 'datetime',
        'presupuesto_aprobado'  => 'decimal:2',
        'costo_real'        => 'decimal:2',
        'activo'            => 'boolean',
    ];

    // ── Relaciones ──────────────────────────────────────────

    public function activoRelacionado(): MorphTo
    {
        // El nombre debe coincidir con el método: 'activo' choca con la columna booleana
        // y rompe el eager loading (with('activoRelacionado') quedaba en null).
        return $this->morphTo(__FUNCTION__, 'activo_type', 'activo_id');
    }

    public function criticidadMantenimiento(): BelongsTo
    {
        return $this->belongsTo(CriticidadMantenimiento::class, 'criticidad_mantenimiento_id');
    }

    public function historial(): HasMany
    {
        return $this->hasMany(MantenimientoHistorial::class)->orderByDesc('created_at');
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(MantenimientoDocumento::class);
    }

    public function garantias(): HasMany
    {
        return $this->hasMany(Garantia::class);
    }

    public function periodicidadMantenimiento(): BelongsTo
    {
        return $this->belongsTo(PeriodicidadMantenimiento::class);
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

    public function scopePorCriticidad($query, $criticidadId)
    {
        return $query->where('criticidad_mantenimiento_id', $criticidadId);
    }

    // ── Accessors ───────────────────────────────────────────

    public function getEstadoBadgeAttribute(): string
    {
        return match ($this->estado) {
            'programado' => '<span class="rounded-full bg-primary/20 px-2 py-1 text-xs text-primary">Programado</span>',
            'en_proceso' => '<span class="rounded-full bg-warning/20 px-2 py-1 text-xs text-warning">En Proceso</span>',
            'completado' => '<span class="rounded-full bg-success/20 px-2 py-1 text-xs text-success">Completado</span>',
            'cancelado'  => '<span class="rounded-full bg-danger/20 px-2 py-1 text-xs text-danger">Cancelado</span>',
            default      => '<span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500">Desconocido</span>',
        };
    }

    public function getTipoMantenimientoBadgeAttribute(): string
    {
        return match ($this->tipo_mantenimiento) {
            'preventivo' => '<span class="rounded-full bg-success/20 px-2 py-1 text-xs text-success">Preventivo</span>',
            'correctivo' => '<span class="rounded-full bg-danger/20 px-2 py-1 text-xs text-danger">Correctivo</span>',
            'predictivo' => '<span class="rounded-full bg-primary/20 px-2 py-1 text-xs text-primary">Predictivo</span>',
            default      => '<span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500">Desconocido</span>',
        };
    }

    /**
     * Etiqueta del criterio del mantenimiento.
     */
    public function getCriterioMantenimientoBadgeAttribute(): string
    {
        $label = match ($this->criterio_mantenimiento) {
            'riesgo_vida'           => 'Riesgo de Vida',
            'riesgo_operacional'    => 'Riesgo Operacional',
            'riesgo_sancionatorio'  => 'Riesgo Sancionatorio',
            'riesgo_activo'         => 'Riesgo sobre Activo',
            default                 => 'Sin criterio',
        };

        return '<span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-700">' . $label . '</span>';
    }

    /**
     * Etiqueta de la criticidad (reutiliza el badge del modelo relacionado).
     */
    public function getCriticidadMantenimientoBadgeAttribute(): string
    {
        return $this->criticidadMantenimiento?->badge
            ?? '<span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500">Sin criticidad</span>';
    }

    public function getNombreActivoAttribute(): string
    {
        return $this->activoRelacionado?->nombre ?? 'N/A';
    }

    // ── Métodos helper ──────────────────────────────────────

    /**
     * Cambia el estado del mantenimiento y registra el cambio en el historial.
     *
     * @param string      $nuevoEstado  Uno de: programado, en_proceso, completado, cancelado.
     * @param array       $opciones     Arreglo con claves opcionales:
     *                                  - comentario (string)
     *                                  - costo_real (float)
     *                                  - user_id    (int) — si no se pasa, usa auth()->id()
     *                                  - user_nombre(string) — si no se pasa, usa auth()->user()->full_name
     *
     * @return MantenimientoHistorial
     */
    public function cambiarEstado(string $nuevoEstado, array $opciones = []): MantenimientoHistorial
    {
        $estadoAnterior = $this->estado;

        // Actualizar el estado del mantenimiento
        $this->estado = $nuevoEstado;

        // Si se marca como completado, guardar el timestamp y el costo real
        if ($nuevoEstado === 'completado') {
            $this->fecha_completado = now();
            if (isset($opciones['costo_real'])) {
                $this->costo_real = $opciones['costo_real'];
            }
        }

        $this->save();

        // Registrar en el historial
        $user = auth()->user();

        return $this->historial()->create([
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo'    => $nuevoEstado,
            'comentario'      => $opciones['comentario'] ?? null,
            'costo_real'      => $opciones['costo_real'] ?? null,
            'user_id'         => $opciones['user_id']     ?? $user?->id,
            'user_nombre'     => $opciones['user_nombre'] ?? $user?->full_name,
        ]);
    }
}
