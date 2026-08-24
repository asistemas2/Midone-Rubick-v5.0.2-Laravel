<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FichaTecnicaInmueble extends Model
{
    use HasFactory;

    protected $table = 'fichas_tecnicas_inmuebles';

    protected $fillable = [
        'inmueble_id',
        'area_calificada', 'area_util', 'area_bruta',
        'capacidad_electrica', 'agua_diametro', 'tuberia_aguas_lluvias',
        'cajas_inspeccion_pluvial', 'red_contra_incendios', 'gabinetes_ci',
        'cubierta', 'muros', 'acabados', 'pisos', 'blindaje_juntas',
        'estructura', 'puertas_ventanas',
        'muelle', 'mezzanine', 'bloques_banos', 'cocineta',
    ];

    protected $casts = [
        'muelle' => 'boolean',
        'mezzanine' => 'boolean',
        'cocineta' => 'boolean',
        'area_calificada' => 'decimal:2',
        'area_util' => 'decimal:2',
        'area_bruta' => 'decimal:2',
    ];

    public function inmueble(): BelongsTo
    {
        return $this->belongsTo(Inmueble::class);
    }
}