<?php

namespace App\Http\Requests\Concerns;

/**
 * Para formularios con el switch "Activo": un checkbox apagado no se envía,
 * así que la ausencia del campo significa `false`. Se normaliza en el servidor
 * para no depender solo del <input type="hidden" name="activo" value="0"> de la vista.
 *
 * Úsalo SOLO en FormRequests cuyo formulario tenga el switch; si no, cada edición
 * desactivaría el registro.
 */
trait NormalizaActivo
{
    protected function prepareForValidation(): void
    {
        $this->merge(['activo' => $this->boolean('activo')]);
    }
}
