<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GarantiasSeeder extends Seeder
{
    public function run(): void
    {
        $mantenimientos = DB::table('mantenimientos')->pluck('id', 'codigo')->toArray();

        $garantias = [
            [
                'codigo' => 'GAR-001',
                'mantenimiento_codigo' => 'MT-002',
                'tipo_activo' => 'inmueble',
                'activo_id' => 1,
                'fecha_inicio' => '2026-02-01',
                'fecha_fin' => '2027-02-01',
                'proveedor' => 'HidroServicios del Valle S.A.S.',
                'estado' => 'activa',
                'terminos' => 'Garantía de 12 meses sobre repuestos instalados y mano de obra. Cubre reemplazo de membranas de filtración y válvulas. No cubre daños por sobretensión eléctrica.',
                'monto' => null,
                'observaciones' => 'Garantía aplica únicamente para los componentes reemplazados durante el mantenimiento correctivo.',
            ],
            [
                'codigo' => 'GAR-002',
                'mantenimiento_codigo' => 'MT-005',
                'tipo_activo' => 'inmueble',
                'activo_id' => 1,
                'fecha_inicio' => '2026-01-15',
                'fecha_fin' => '2026-07-15',
                'proveedor' => 'Crear Arquitectura S.A.S.',
                'estado' => 'activa',
                'terminos' => 'Garantía de 6 meses sobre reparaciones de cubierta. Cubre filtraciones en áreas intervenidas. Incluye una visita de verificación al mes 3.',
                'monto' => null,
                'observaciones' => 'Se recomienda inspección de seguimiento antes de que venza la garantía.',
            ],
            [
                'codigo' => 'GAR-003',
                'mantenimiento_codigo' => 'MT-008',
                'tipo_activo' => 'equipo',
                'activo_id' => 1,
                'fecha_inicio' => '2025-11-15',
                'fecha_fin' => '2026-05-15',
                'proveedor' => 'ClimaTech Colombia S.A.S.',
                'estado' => 'activa',
                'terminos' => 'Garantía de 6 meses sobre gas refrigerante recargado y componentes eléctricos reemplazados. No cubre obstrucciones por mal uso.',
                'monto' => null,
                'observaciones' => 'Próxima revisión programada antes de vencimiento de garantía.',
            ],
            [
                'codigo' => 'GAR-004',
                'mantenimiento_codigo' => 'MT-012',
                'tipo_activo' => 'equipo',
                'activo_id' => 1,
                'fecha_inicio' => '2025-09-01',
                'fecha_fin' => '2026-03-01',
                'proveedor' => 'FireProtect S.A.S.',
                'estado' => 'activa',
                'terminos' => 'Garantía de 6 meses sobre sensores reemplazados y panel de control reparado. Incluye soporte técnico remoto.',
                'monto' => null,
                'observaciones' => 'Garantía próxima a vencer. Programar revisión final.',
            ],
            [
                'codigo' => 'GAR-005',
                'mantenimiento_codigo' => 'MT-015',
                'tipo_activo' => 'equipo',
                'activo_id' => 1,
                'fecha_inicio' => '2025-06-20',
                'fecha_fin' => '2025-12-20',
                'proveedor' => 'DoorTech Industrial S.A.S.',
                'estado' => 'vencida',
                'terminos' => 'Garantía de 6 meses sobre motor y sistema de rieles. Cubre fallas mecánicas y eléctricas.',
                'monto' => null,
                'observaciones' => 'Garantía vencida el 20/12/2025. Se requiere nueva evaluación del equipo.',
            ],
            [
                'codigo' => 'GAR-006',
                'mantenimiento_codigo' => 'MT-018',
                'tipo_activo' => 'equipo',
                'activo_id' => 1,
                'fecha_inicio' => '2025-05-01',
                'fecha_fin' => '2025-11-01',
                'proveedor' => 'BombasTech S.A.S.',
                'estado' => 'vencida',
                'terminos' => 'Garantía de 6 meses sobre impulsor y sellos mecánicos reemplazados.',
                'monto' => null,
                'observaciones' => 'Garantía vencida. Equipo operando normalmente.',
            ],
            [
                'codigo' => 'GAR-007',
                'mantenimiento_codigo' => 'MT-021',
                'tipo_activo' => 'equipo',
                'activo_id' => 1,
                'fecha_inicio' => null,
                'fecha_fin' => null,
                'proveedor' => 'ElectroServ S.A.S.',
                'estado' => 'en_tramite',
                'terminos' => 'Pendiente definir términos de garantía con el proveedor.',
                'monto' => null,
                'observaciones' => 'Solicitud de garantía en proceso. Esperando respuesta del proveedor sobre cobertura de componentes eléctricos.',
            ],
            [
                'codigo' => 'GAR-008',
                'mantenimiento_codigo' => 'MT-003',
                'tipo_activo' => 'equipo',
                'activo_id' => 1,
                'fecha_inicio' => null,
                'fecha_fin' => null,
                'proveedor' => 'GenerPower Colombia S.A.',
                'estado' => 'en_tramite',
                'terminos' => 'En negociación: cobertura de 12 meses sobre alternador y sistema de transferencia automática.',
                'monto' => null,
                'observaciones' => 'Proveedor revisando alcance de la garantía. Respuesta esperada para el 20/03/2026.',
            ],
        ];

        foreach ($garantias as $item) {
            $mantId = $mantenimientos[$item['mantenimiento_codigo']] ?? null;

            DB::table('garantias')->updateOrInsert(
                ['codigo' => $item['codigo']],
                [
                    'mantenimiento_id' => $mantId,
                    'tipo_activo' => $item['tipo_activo'],
                    'activo_id' => $item['activo_id'],
                    'fecha_inicio' => $item['fecha_inicio'],
                    'fecha_fin' => $item['fecha_fin'],
                    'proveedor' => $item['proveedor'],
                    'terminos' => $item['terminos'],
                    'monto' => $item['monto'],
                    'estado' => $item['estado'],
                    'observaciones' => $item['observaciones'],
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
