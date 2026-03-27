<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasEquipoSeeder extends Seeder
{
    public function run(): void
    {
        // Mapeo de tipo_equipo nombre => id (asumiendo orden de TiposEquipoSeeder)
        $tipoIds = DB::table('tipos_equipo')->pluck('id', 'nombre')->toArray();

        $categorias = [
            ['Transformador de potencia', 'Eléctrico'],
            ['Transformador de distribución', 'Eléctrico'],
            ['Transformador seco', 'Eléctrico'],
            ['Transformador de corriente', 'Eléctrico'],
            ['Transformador de potencial', 'Eléctrico'],
            ['Generador eléctrico', 'Eléctrico'],
            ['Generador de emergencia', 'Eléctrico'],
            ['Planta eléctrica diésel', 'Eléctrico'],
            ['UPS en línea', 'Eléctrico'],
            ['UPS interactiva', 'Eléctrico'],
            ['UPS modular', 'Eléctrico'],
            ['Tablero de distribución', 'Eléctrico'],
            ['Tablero de transferencia automática', 'Eléctrico'],
            ['Celda de media tensión', 'Eléctrico'],
            ['Seccionador', 'Eléctrico'],
            ['Interruptor automático', 'Eléctrico'],
            ['Reconectador', 'Eléctrico'],
            ['Banco de condensadores', 'Eléctrico'],
            ['Regulador de voltaje', 'Eléctrico'],
            ['Pararrayos', 'Eléctrico'],
            ['Sistema de puesta a tierra', 'Eléctrico'],
            ['Cableado estructurado', 'Eléctrico'],
            ['Luminaria LED', 'Eléctrico'],
            ['Luminaria fluorescente', 'Eléctrico'],
            ['Reflector industrial', 'Eléctrico'],
            ['Poste de alumbrado', 'Eléctrico'],
            ['Subestación eléctrica', 'Eléctrico'],
            ['Barraje eléctrico', 'Eléctrico'],
            ['Bomba centrífuga', 'Hidráulico'],
            ['Bomba sumergible', 'Hidráulico'],
            ['Bomba de pozo profundo', 'Hidráulico'],
            ['Bomba de presión constante', 'Hidráulico'],
            ['Bomba dosificadora', 'Hidráulico'],
            ['Motobomba', 'Hidráulico'],
            ['Electrobomba', 'Hidráulico'],
            ['Tanque de almacenamiento', 'Hidráulico'],
            ['Tanque elevado', 'Hidráulico'],
            ['Tanque de abastecimiento', 'Hidráulico'],
            ['Válvula de compuerta', 'Hidráulico'],
            ['Válvula de retención', 'Hidráulico'],
            ['Válvula de mariposa', 'Hidráulico'],
            ['Hidrante', 'Hidráulico'],
            ['Red contra incendio', 'Hidráulico'],
            ['Tubería de conducción', 'Hidráulico'],
            ['Pozo profundo', 'Hidráulico'],
            ['Planta de tratamiento de agua potable', 'Hidráulico'],
            ['Planta de tratamiento de aguas residuales', 'Hidráulico'],
            ['Filtro de arena', 'Hidráulico'],
            ['Filtro de carbón activado', 'Hidráulico'],
            ['Sistema de cloración', 'Hidráulico'],
            ['Estación de bombeo', 'Hidráulico'],
            ['Cámara de aguas residuales', 'Hidráulico'],
            ['Aire acondicionado split', 'HVAC'],
            ['Aire acondicionado tipo cassette', 'HVAC'],
            ['Aire acondicionado tipo piso-techo', 'HVAC'],
            ['Aire acondicionado centralizado', 'HVAC'],
            ['Unidad manejadora de aire', 'HVAC'],
            ['Chiller', 'HVAC'],
            ['Fan coil', 'HVAC'],
            ['Ventilador industrial', 'HVAC'],
            ['Ventilador axial', 'HVAC'],
            ['Extractor de aire', 'HVAC'],
            ['Ducto de ventilación', 'HVAC'],
            ['Torre de enfriamiento', 'HVAC'],
            ['Medidor de energía monofásico', 'Medición'],
            ['Medidor de energía bifásico', 'Medición'],
            ['Medidor de energía trifásico', 'Medición'],
            ['Medidor de agua', 'Medición'],
            ['Medidor de gas', 'Medición'],
            ['Medidor de caudal', 'Medición'],
            ['Analizador de redes eléctricas', 'Medición'],
            ['Báscula vehicular', 'General'],
            ['Báscula industrial', 'General'],
            ['Planta telefónica', 'General'],
            ['Servidor de cómputo', 'General'],
            ['Switch de red', 'General'],
            ['Router', 'General'],
            ['Sistema de detección de incendios', 'General'],
            ['Panel de alarmas', 'General'],
            ['Elevador de carga', 'General'],
            ['Montacargas', 'General'],
            ['Compresor de aire', 'General'],
            ['Calentador de agua', 'General'],
            ['Equipo de soldadura', 'General'],
            ['Puerta eléctrica', 'General'],
            ['Cámara de vigilancia IP', 'Seguridad'],
            ['DVR / NVR', 'Seguridad'],
            ['Control de acceso biométrico', 'Seguridad'],
            ['Barrera vehicular', 'Seguridad'],
            ['Cerca eléctrica', 'Seguridad'],
        ];

        foreach ($categorias as [$nombre, $tipo]) {
            DB::table('categorias_equipo')->updateOrInsert(
                ['nombre' => $nombre],
                [
                    'tipo_equipo_id' => $tipoIds[$tipo] ?? null,
                    'descripcion'    => null,
                    'activo'         => true,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]
            );
        }
    }
}
