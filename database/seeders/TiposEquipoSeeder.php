<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposEquipoSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de categorías (las 6 generales)
        $categorias = DB::table('categorias_equipo')->pluck('id', 'nombre')->toArray();

        // Lista de tipos específicos (extraída del CSV original de categorias_equipo)
        $tipos = [
            // Eléctrico (categoria_id = $categorias['Eléctrico'])
            ['nombre' => 'Transformador de potencia', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Transformador de distribución', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Transformador seco', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Transformador de corriente', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Transformador de potencial', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Generador eléctrico', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Generador de emergencia', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Planta eléctrica diésel', 'categoria' => 'Eléctrico'],
            ['nombre' => 'UPS en línea', 'categoria' => 'Eléctrico'],
            ['nombre' => 'UPS interactiva', 'categoria' => 'Eléctrico'],
            ['nombre' => 'UPS modular', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Tablero de distribución', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Tablero de transferencia automática', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Celda de media tensión', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Seccionador', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Interruptor automático', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Reconectador', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Banco de condensadores', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Regulador de voltaje', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Pararrayos', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Sistema de puesta a tierra', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Cableado estructurado', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Luminaria LED', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Luminaria fluorescente', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Reflector industrial', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Poste de alumbrado', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Subestación eléctrica', 'categoria' => 'Eléctrico'],
            ['nombre' => 'Barraje eléctrico', 'categoria' => 'Eléctrico'],
            // Hidráulico
            ['nombre' => 'Bomba centrífuga', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Bomba sumergible', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Bomba de pozo profundo', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Bomba de presión constante', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Bomba dosificadora', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Motobomba', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Electrobomba', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Tanque de almacenamiento', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Tanque elevado', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Tanque de abastecimiento', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Válvula de compuerta', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Válvula de retención', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Válvula de mariposa', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Hidrante', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Red contra incendio', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Tubería de conducción', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Pozo profundo', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Planta de tratamiento de agua potable', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Planta de tratamiento de aguas residuales', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Filtro de arena', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Filtro de carbón activado', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Sistema de cloración', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Estación de bombeo', 'categoria' => 'Hidráulico'],
            ['nombre' => 'Cámara de aguas residuales', 'categoria' => 'Hidráulico'],
            // HVAC
            ['nombre' => 'Aire acondicionado split', 'categoria' => 'HVAC'],
            ['nombre' => 'Aire acondicionado tipo cassette', 'categoria' => 'HVAC'],
            ['nombre' => 'Aire acondicionado tipo piso-techo', 'categoria' => 'HVAC'],
            ['nombre' => 'Aire acondicionado centralizado', 'categoria' => 'HVAC'],
            ['nombre' => 'Unidad manejadora de aire', 'categoria' => 'HVAC'],
            ['nombre' => 'Chiller', 'categoria' => 'HVAC'],
            ['nombre' => 'Fan coil', 'categoria' => 'HVAC'],
            ['nombre' => 'Ventilador industrial', 'categoria' => 'HVAC'],
            ['nombre' => 'Ventilador axial', 'categoria' => 'HVAC'],
            ['nombre' => 'Extractor de aire', 'categoria' => 'HVAC'],
            ['nombre' => 'Ducto de ventilación', 'categoria' => 'HVAC'],
            ['nombre' => 'Torre de enfriamiento', 'categoria' => 'HVAC'],
            // Medición
            ['nombre' => 'Medidor de energía monofásico', 'categoria' => 'Medición'],
            ['nombre' => 'Medidor de energía bifásico', 'categoria' => 'Medición'],
            ['nombre' => 'Medidor de energía trifásico', 'categoria' => 'Medición'],
            ['nombre' => 'Medidor de agua', 'categoria' => 'Medición'],
            ['nombre' => 'Medidor de gas', 'categoria' => 'Medición'],
            ['nombre' => 'Medidor de caudal', 'categoria' => 'Medición'],
            ['nombre' => 'Analizador de redes eléctricas', 'categoria' => 'Medición'],
            // General
            ['nombre' => 'Báscula vehicular', 'categoria' => 'General'],
            ['nombre' => 'Báscula industrial', 'categoria' => 'General'],
            ['nombre' => 'Planta telefónica', 'categoria' => 'General'],
            ['nombre' => 'Servidor de cómputo', 'categoria' => 'General'],
            ['nombre' => 'Switch de red', 'categoria' => 'General'],
            ['nombre' => 'Router', 'categoria' => 'General'],
            ['nombre' => 'Sistema de detección de incendios', 'categoria' => 'General'],
            ['nombre' => 'Panel de alarmas', 'categoria' => 'General'],
            ['nombre' => 'Elevador de carga', 'categoria' => 'General'],
            ['nombre' => 'Montacargas', 'categoria' => 'General'],
            ['nombre' => 'Compresor de aire', 'categoria' => 'General'],
            ['nombre' => 'Calentador de agua', 'categoria' => 'General'],
            ['nombre' => 'Equipo de soldadura', 'categoria' => 'General'],
            ['nombre' => 'Puerta eléctrica', 'categoria' => 'General'],
            // Seguridad
            ['nombre' => 'Cámara de vigilancia IP', 'categoria' => 'Seguridad'],
            ['nombre' => 'DVR / NVR', 'categoria' => 'Seguridad'],
            ['nombre' => 'Control de acceso biométrico', 'categoria' => 'Seguridad'],
            ['nombre' => 'Barrera vehicular', 'categoria' => 'Seguridad'],
            ['nombre' => 'Cerca eléctrica', 'categoria' => 'Seguridad'],
        ];

        foreach ($tipos as $t) {
            DB::table('tipos_equipo')->updateOrInsert(
                ['nombre' => $t['nombre']],
                [
                    'categoria_equipo_id' => $categorias[$t['categoria']] ?? null,
                    'descripcion' => null,
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}