<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Genera códigos consecutivos con formato PREFIJO-0000 (MT-0933, INM-0106...).
 *
 * - Seguro con usuarios concurrentes: bloquea la fila del prefijo en `consecutivos`.
 * - Respeta los códigos existentes: continúa desde el número más alto que ya exista
 *   en la tabla (incluidos registros eliminados), aunque tenga otro relleno (INM-105, MT-0932).
 * - Un número puede quedar sin usar si el guardado falla después de generarlo; nunca se repite.
 */
class Consecutivo
{
    public const DIGITOS = 4;

    public static function siguiente(string $prefijo, string $tabla, string $columna = 'codigo'): string
    {
        return DB::transaction(function () use ($prefijo, $tabla, $columna) {
            DB::table('consecutivos')->insertOrIgnore([
                'prefijo' => $prefijo, 'ultimo' => 0, 'created_at' => now(), 'updated_at' => now(),
            ]);

            $ultimo = (int) DB::table('consecutivos')
                ->where('prefijo', $prefijo)
                ->lockForUpdate()
                ->value('ultimo');

            $numero = max($ultimo, self::mayorExistente($prefijo, $tabla, $columna)) + 1;

            DB::table('consecutivos')
                ->where('prefijo', $prefijo)
                ->update(['ultimo' => $numero, 'updated_at' => now()]);

            return self::formatear($prefijo, $numero);
        });
    }

    public static function formatear(string $prefijo, int $numero): string
    {
        return $prefijo . '-' . str_pad((string) $numero, self::DIGITOS, '0', STR_PAD_LEFT);
    }

    /** Número más alto ya usado con ese prefijo (DB::table no aplica SoftDeletes). */
    private static function mayorExistente(string $prefijo, string $tabla, string $columna): int
    {
        $patron = '/^' . preg_quote($prefijo, '/') . '-(\d+)$/';

        return (int) DB::table($tabla)
            ->where($columna, 'like', $prefijo . '-%')
            ->pluck($columna)
            ->map(fn ($codigo) => preg_match($patron, $codigo, $m) ? (int) $m[1] : 0)
            ->max();
    }
}
