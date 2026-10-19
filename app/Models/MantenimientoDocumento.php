<?php
// app/Models/MantenimientoDocumento.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MantenimientoDocumento extends Model
{
    use HasFactory;

    protected $table = 'mantenimiento_documentos';

    protected $fillable = [
        'mantenimiento_id',
        'tipo',
        'nombre_original',
        'ruta',
        'mime_type',
        'tamano_bytes',
        'descripcion',
        'user_id',
    ];

    protected $casts = [
        'tamano_bytes' => 'integer',
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

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // ── Accessors ───────────────────────────────────────────

    /**
     * Tamaño legible (KB, MB, etc.).
     */
    public function getTamanoLegibleAttribute(): string
    {
        if (!$this->tamano_bytes) {
            return '—';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->tamano_bytes;
        $i = 0;

        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }

        return round($size, 2) . ' ' . $units[$i];
    }

    /**
     * Nombre amigable del tipo de documento.
     */
    public function getTipoLegibleAttribute(): string
    {
        return match ($this->tipo) {
            'orden_compra'           => 'Orden de Compra',
            'factura'                => 'Factura',
            'evidencia_fotografica'  => 'Evidencia Fotográfica',
            'acta'                   => 'Acta',
            'otro'                   => 'Otro',
            default                  => ucfirst($this->tipo),
        };
    }
}