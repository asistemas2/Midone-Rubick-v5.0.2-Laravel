<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Búsqueda de texto para los listados: ->buscar(['nombre', 'codigo'], $request->buscar)
         * - Agrupa los OR entre paréntesis para no anular los demás filtros ni el scope activos().
         * - No distingue mayúsculas (en PostgreSQL `like` sí las distingue).
         * - Si el término está vacío no aplica nada.
         */
        Builder::macro('buscar', function (array $columnas, ?string $termino) {
            $termino = trim((string) $termino);

            if ($termino === '') {
                return $this;
            }

            $operador = $this->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
            $patron = '%' . addcslashes($termino, '%_\\') . '%';

            return $this->where(function (Builder $q) use ($columnas, $operador, $patron) {
                foreach ($columnas as $columna) {
                    $q->orWhere($columna, $operador, $patron);
                }
            });
        });
    }
}
