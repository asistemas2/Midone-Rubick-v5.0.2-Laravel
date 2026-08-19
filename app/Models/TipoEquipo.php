<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoEquipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_equipo';

    protected $fillable = [
        'nombre',
        'categoria_equipo_id',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Relación: un tipo pertenece a una categoría (nivel superior)
    public function categoriaEquipo()
    {
        return $this->belongsTo(CategoriaEquipo::class);
    }
}