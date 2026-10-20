<?php

namespace App\Models\Concerns;

use App\Support\Consecutivo;

/**
 * Asigna el código consecutivo (PREFIJO-0000) al crear el registro si no viene uno.
 * El modelo debe declarar: public const PREFIJO_CODIGO = 'XX';
 */
trait TieneConsecutivo
{
    public static function bootTieneConsecutivo(): void
    {
        static::creating(function (self $modelo) {
            if (blank($modelo->codigo)) {
                $modelo->codigo = Consecutivo::siguiente(static::PREFIJO_CODIGO, $modelo->getTable());
            }
        });
    }
}
