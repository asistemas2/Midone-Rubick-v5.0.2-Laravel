<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaEquipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categorias_equipo';

    protected $fillable = [
        'nombre',
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

    // Relación: una categoría tiene muchos tipos (nivel inferior)
    public function tiposEquipo()
    {
        return $this->hasMany(TipoEquipo::class);
    }
}