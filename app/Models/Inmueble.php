<?php

namespace App\Models;

use App\Models\Concerns\TieneConsecutivo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Inmueble extends Model
{
    use HasFactory, SoftDeletes, TieneConsecutivo;

    /** Prefijo del código consecutivo (ver App\Support\Consecutivo). */
    public const PREFIJO_CODIGO = 'INM';

    protected $table = 'inmuebles';

    protected $fillable = [
        'codigo',
        'nombre',
        'bloque_id',
        'tipo_inmueble_id',
        'direccion',
        'area_m2',
        'area_construida_m2',
        'latitud',
        'longitud',
        'estado',
        'nivel_deterioro_id',
        'fecha_construccion',
        'valor_catastral',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'area_m2' => 'decimal:2',
        'area_construida_m2' => 'decimal:2',
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
        'valor_catastral' => 'decimal:2',
        'fecha_construccion' => 'date',
        'activo' => 'boolean',
    ];

    // ── Relaciones ──────────────────────────────────────────

    public function bloque(): BelongsTo
    {
        return $this->belongsTo(Bloque::class);
    }

    public function tipoInmueble(): BelongsTo
    {
        return $this->belongsTo(TipoInmueble::class);
    }

    public function nivelDeterioro(): BelongsTo
    {
        return $this->belongsTo(NivelDeterioro::class);
    }

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class);
    }

    public function mantenimientos(): MorphMany
    {
        return $this->morphMany(Mantenimiento::class, 'activo', 'activo_type', 'activo_id');
    }

    /** Garantías del inmueble (garantias guarda tipo_activo + activo_id, sin activo_type). */
    public function garantias(): HasMany
    {
        return $this->hasMany(Garantia::class, 'activo_id')->where('tipo_activo', 'inmueble');
    }

    public function fichaTecnica()
    {
        return $this->hasOne(FichaTecnicaInmueble::class);
    }

    // ── Scopes ──────────────────────────────────────────────

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeOperativos($query)
    {
        return $query->where('estado', 'operativo');
    }

    public function scopeEnMantenimiento($query)
    {
        return $query->where('estado', 'mantenimiento');
    }

    // ── Accessors ───────────────────────────────────────────

    public function getCoordenadasAttribute(): ?string
    {
        if ($this->latitud && $this->longitud) {
            return $this->latitud . ', ' . $this->longitud;
        }
        return null;
    }

    /**
     * Solo las bodegas llevan ficha técnica. Si el inmueble cambia a otro tipo
     * su ficha se conserva en BD pero no se muestra ni se edita.
     */
    public function esBodega(): bool
    {
        return $this->tipoInmueble?->esBodega() ?? false;
    }

    public function getEsBodegaAttribute(): bool
    {
        return $this->esBodega();
    }

    public function getTieneCoordenadasAttribute(): bool
    {
        return !is_null($this->latitud) && !is_null($this->longitud);
    }

    public function getEstadoBadgeAttribute(): string
    {
        return match ($this->estado) {
            'operativo' => '<span class="rounded-full bg-success/20 px-2 py-1 text-xs text-success">Operativo</span>',
            'mantenimiento' => '<span class="rounded-full bg-warning/20 px-2 py-1 text-xs text-warning">En Mantenimiento</span>',
            'fuera_servicio' => '<span class="rounded-full bg-danger/20 px-2 py-1 text-xs text-danger">Fuera de Servicio</span>',
            default => '<span class="rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500">Desconocido</span>',
        };
    }
}
