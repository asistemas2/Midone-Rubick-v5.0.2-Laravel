<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Equipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'equipos';

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo_equipo_id',
        'categoria_equipo_id',
        'marca_id',
        'modelo',
        'no_serie',
        'inmueble_id',
        'ubicacion_especifica',
        'capacidad',
        'voltaje',
        'potencia',
        'frecuencia',
        'descripcion',
        'fecha_adquisicion',
        'fecha_instalacion',
        'vida_util_anios',
        'proveedor',
        'garantia_meses',
        'estado_equipo_id',
        'criticidad_id',
        'periodicidad_mantenimiento_id',
        'ultimo_mantenimiento',
        'proximo_mantenimiento',
        'responsable',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date',
        'fecha_instalacion' => 'date',
        'ultimo_mantenimiento' => 'date',
        'proximo_mantenimiento' => 'date',
        'vida_util_anios' => 'integer',
        'garantia_meses' => 'integer',
        'activo' => 'boolean',
    ];

    // ── Relaciones ──────────────────────────────────────────

    public function tipoEquipo(): BelongsTo
    {
        return $this->belongsTo(TipoEquipo::class);
    }

    public function categoriaEquipo(): BelongsTo
    {
        return $this->belongsTo(CategoriaEquipo::class);
    }

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function inmueble(): BelongsTo
    {
        return $this->belongsTo(Inmueble::class);
    }

    public function estadoEquipo(): BelongsTo
    {
        return $this->belongsTo(EstadoEquipo::class);
    }

    public function criticidad(): BelongsTo
    {
        return $this->belongsTo(Criticidad::class);
    }

    public function periodicidadMantenimiento(): BelongsTo
    {
        return $this->belongsTo(PeriodicidadMantenimiento::class);
    }

    public function mantenimientos(): MorphMany
    {
        return $this->morphMany(Mantenimiento::class, 'activo', 'activo_type', 'activo_id');
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorTipo($query, $tipoEquipoId)
    {
        return $query->where('tipo_equipo_id', $tipoEquipoId);
    }

    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_equipo_id', $categoriaId);
    }

    public function scopePorEstado($query, $estadoId)
    {
        return $query->where('estado_equipo_id', $estadoId);
    }

    public function scopePorCriticidad($query, $criticidadId)
    {
        return $query->where('criticidad_id', $criticidadId);
    }

    public function scopeMantenimientoVencido($query)
    {
        return $query->whereNotNull('proximo_mantenimiento')
                     ->where('proximo_mantenimiento', '<', now());
    }
}
