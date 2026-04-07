<?php

namespace App\Http\Controllers;

use App\Models\Inmueble;
use App\Models\Equipo;
use App\Models\Mantenimiento;
use App\Models\Garantia;
use App\Models\Bloque;
use App\Models\TipoInmueble;
use App\Models\TipoEquipo;
use App\Models\EstadoEquipo;
use App\Models\Criticidad;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // ── KPIs ────────────────────────────────────────────────
        $totalInmuebles = Inmueble::activos()->count();
        $totalEquipos = Equipo::activos()->count();
        $mantPendientes = Mantenimiento::activos()
            ->whereIn('estado', ['programado', 'en_proceso'])
            ->count();
        $garantiasActivas = Garantia::activos()
            ->where('estado', 'activa')
            ->count();

        // ── Alertas ─────────────────────────────────────────────
        $alertas = collect();

        // Mantenimientos vencidos
        $mantVencidos = Mantenimiento::activos()
            ->whereIn('estado', ['programado', 'en_proceso'])
            ->whereNotNull('fecha_programada')
            ->where('fecha_programada', '<', $today)
            ->with('activoRelacionado')
            ->orderBy('fecha_programada')
            ->limit(5)
            ->get();

        foreach ($mantVencidos as $m) {
            $dias = $today->diffInDays($m->fecha_programada);
            $alertas->push([
                'tipo' => 'danger',
                'icono' => 'AlertTriangle',
                'texto' => "<strong>{$m->codigo}</strong> — {$m->nombre_activo}: mantenimiento <strong>vencido</strong> hace {$dias} día(s)",
                'link' => route('gestion.mantenimientos.show', $m),
            ]);
        }

        // Mantenimientos próximos (7 días)
        $mantProximos = Mantenimiento::activos()
            ->whereIn('estado', ['programado', 'en_proceso'])
            ->whereNotNull('fecha_programada')
            ->whereBetween('fecha_programada', [$today, $today->copy()->addDays(7)])
            ->with('activoRelacionado')
            ->orderBy('fecha_programada')
            ->limit(5)
            ->get();

        foreach ($mantProximos as $m) {
            $dias = $today->diffInDays($m->fecha_programada);
            $alertas->push([
                'tipo' => 'warning',
                'icono' => 'Clock',
                'texto' => "<strong>{$m->codigo}</strong> — {$m->nombre_activo}: mantenimiento en <strong>{$dias} día(s)</strong>",
                'link' => route('gestion.mantenimientos.show', $m),
            ]);
        }

        // Garantías por vencer (30 días)
        $garantiasPorVencer = Garantia::activos()
            ->where('estado', 'activa')
            ->whereNotNull('fecha_fin')
            ->whereBetween('fecha_fin', [$today, $today->copy()->addDays(30)])
            ->limit(5)
            ->get();

        foreach ($garantiasPorVencer as $g) {
            $dias = $today->diffInDays($g->fecha_fin);
            $alertas->push([
                'tipo' => 'info',
                'icono' => 'ShieldAlert',
                'texto' => "Garantía <strong>{$g->codigo}</strong> vence en <strong>{$dias} día(s)</strong>",
                'link' => route('gestion.garantias.show', $g),
            ]);
        }

        // Garantías en trámite
        $enTramite = Garantia::activos()->where('estado', 'en_tramite')->count();
        if ($enTramite > 0) {
            $alertas->push([
                'tipo' => 'success',
                'icono' => 'Hourglass',
                'texto' => "<strong>{$enTramite}</strong> garantía(s) en trámite pendientes de resolución",
                'link' => route('gestion.garantias.index', ['estado' => 'en_tramite']),
            ]);
        }

        // ── Gráficos ────────────────────────────────────────────

        // Distribución de inmuebles por tipo
        $inmueblesPorTipo = Inmueble::activos()
            ->selectRaw('tipo_inmueble_id, COUNT(*) as total')
            ->groupBy('tipo_inmueble_id')
            ->with('tipoInmueble')
            ->get()
            ->map(fn($item) => [
                'label' => $item->tipoInmueble->nombre ?? 'Sin tipo',
                'value' => $item->total,
            ]);

        // Estado de mantenimientos
        $mantPorEstado = Mantenimiento::activos()
            ->selectRaw("estado, COUNT(*) as total")
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        $estadosMantenimiento = [
            'programado' => $mantPorEstado['programado'] ?? 0,
            'en_proceso' => $mantPorEstado['en_proceso'] ?? 0,
            'completado' => $mantPorEstado['completado'] ?? 0,
            'cancelado' => $mantPorEstado['cancelado'] ?? 0,
        ];

        // Equipos por criticidad
        $equiposPorCriticidad = Equipo::activos()
            ->selectRaw('criticidad_id, COUNT(*) as total')
            ->whereNotNull('criticidad_id')
            ->groupBy('criticidad_id')
            ->with('criticidad')
            ->get()
            ->map(fn($item) => [
                'label' => $item->criticidad->nombre ?? 'Sin criticidad',
                'value' => $item->total,
                'color' => $item->criticidad->color_hex ?? '#6c757d',
            ]);

        // Mantenimientos por tipo
        $mantPorTipo = Mantenimiento::activos()
            ->selectRaw("tipo_mantenimiento, COUNT(*) as total")
            ->groupBy('tipo_mantenimiento')
            ->pluck('total', 'tipo_mantenimiento')
            ->toArray();

        // ── Calendario de Mantenimientos (mes actual) ───────────
        $inicioMes = $today->copy()->startOfMonth();
        $finMes = $today->copy()->endOfMonth();

        $mantEsteMes = Mantenimiento::activos()
            ->whereNotNull('fecha_programada')
            ->whereBetween('fecha_programada', [$inicioMes, $finMes])
            ->with('activoRelacionado')
            ->orderBy('fecha_programada')
            ->get()
            ->groupBy(fn($m) => $m->fecha_programada->format('Y-m-d'));

        // Fechas con eventos para el calendario
        $fechasConEventos = $mantEsteMes->keys()->toArray();

        // ── Datos para la vista ─────────────────────────────────
        return view('pages.dashboard-overview-1', compact(
            'totalInmuebles',
            'totalEquipos',
            'mantPendientes',
            'garantiasActivas',
            'alertas',
            'inmueblesPorTipo',
            'estadosMantenimiento',
            'equiposPorCriticidad',
            'mantPorTipo',
            'fechasConEventos',
            'mantEsteMes',
            'today'
        ) ,[
             'layout' => 'top-menu'
            // Specify the base layout.
            // Eg: 'side-menu', 'simple-menu', 'top-menu', 'login'
            // The default value is 'side-menu'

            // 'layout' => 'side-menu'
        ]);
    }

    /**
     * API: Obtener mantenimientos de un día específico
     */
    public function mantenimientosDia(Request $request)
    {
        $fecha = $request->get('fecha');
        if (!$fecha) {
            return response()->json([]);
        }

        $mantenimientos = Mantenimiento::activos()
            ->whereDate('fecha_programada', $fecha)
            ->with('activoRelacionado')
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'codigo' => $m->codigo,
                'activo' => $m->nombre_activo,
                'tipo' => $m->tipo_mantenimiento,
                'estado' => $m->estado,
                'link' => route('gestion.mantenimientos.show', $m),
            ]);

        return response()->json($mantenimientos);
    }
}
