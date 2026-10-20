<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gestion\StoreMantenimientoRequest;
use App\Http\Requests\Gestion\UpdateMantenimientoRequest;
use App\Models\Mantenimiento;
use App\Models\MantenimientoDocumento;
use App\Models\Inmueble;
use App\Models\Equipo;
use App\Models\CriticidadMantenimiento;
use App\Models\Garantia;
use App\Models\PeriodicidadMantenimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class MantenimientoController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  LISTADO
    // ══════════════════════════════════════════════════════════════

    public function index(Request $request): View
    {
        $mantenimientos = Mantenimiento::activos()
            ->with(['criticidadMantenimiento', 'activoRelacionado'])
            ->buscar(['codigo', 'descripcion'], $request->buscar)
            ->when($request->filled('estado'), function ($query) use ($request) {
                $query->where('estado', $request->estado);
            })
            ->when($request->filled('tipo_activo'), function ($query) use ($request) {
                $query->where('tipo_activo', $request->tipo_activo);
            })
            ->when($request->filled('tipo_mantenimiento'), function ($query) use ($request) {
                $query->where('tipo_mantenimiento', $request->tipo_mantenimiento);
            })
            ->when($request->filled('criticidad_mantenimiento_id'), function ($query) use ($request) {
                $query->where('criticidad_mantenimiento_id', $request->criticidad_mantenimiento_id);
            })
            ->when($request->filled('fecha_desde'), function ($query) use ($request) {
                $query->where('fecha_programada', '>=', $request->fecha_desde);
            })
            ->when($request->filled('fecha_hasta'), function ($query) use ($request) {
                $query->where('fecha_programada', '<=', $request->fecha_hasta);
            })
            ->orderByDesc('fecha_programada')
            ->paginate(15)
            ->withQueryString();

        $criticidades = CriticidadMantenimiento::activos()->ordenadas()->get();

        return view('gestion.mantenimientos.index', compact('mantenimientos', 'criticidades'));
    }

    // ══════════════════════════════════════════════════════════════
    //  CREAR
    // ══════════════════════════════════════════════════════════════

    public function create(): View
    {
        $inmuebles      = Inmueble::activos()->orderBy('nombre')->get();
        $equipos        = Equipo::activos()->orderBy('nombre')->get();
        $criticidades   = CriticidadMantenimiento::activos()->ordenadas()->get();

        return view('gestion.mantenimientos.create', compact(
            'inmuebles',
            'equipos',
            'criticidades'
        ));
    }

    public function store(StoreMantenimientoRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Asignar activo_type según tipo_activo
            $data['activo_type'] = $data['tipo_activo'] === 'inmueble'
                ? 'App\\Models\\Inmueble'
                : 'App\\Models\\Equipo';

            $mantenimiento = Mantenimiento::create($data);

            // Registrar el primer estado en el historial (auditoría de creación)
            $user = auth()->user();
            $mantenimiento->historial()->create([
                'estado_anterior' => null,
                'estado_nuevo'    => $mantenimiento->estado,
                'comentario'      => 'Mantenimiento creado en el sistema.',
                'costo_real'      => null,
                'user_id'         => $user?->id,
                'user_nombre'     => $user?->full_name,
            ]);

            DB::commit();

            return redirect()
                ->route('gestion.mantenimientos.index')
                ->with('success', 'Mantenimiento creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el mantenimiento: ' . $e->getMessage());
        }
    }

    // ══════════════════════════════════════════════════════════════
    //  VER
    // ══════════════════════════════════════════════════════════════

    public function show(Mantenimiento $mantenimiento): View
    {
        $mantenimiento->load([
            'criticidadMantenimiento',
            'periodicidadMantenimiento',
            'activoRelacionado',
            'historial.user',
            'documentos.user',
            'garantias',
        ]);

        $criticidades   = CriticidadMantenimiento::activos()->ordenadas()->get();
        $periodicidades = PeriodicidadMantenimiento::activos()->ordenadas()->get();

        return view('gestion.mantenimientos.show', compact('mantenimiento', 'criticidades', 'periodicidades'));
    }

    // ══════════════════════════════════════════════════════════════
    //  EDITAR
    // ══════════════════════════════════════════════════════════════

    public function edit(Mantenimiento $mantenimiento): View
    {
        $inmuebles    = Inmueble::activos()->orderBy('nombre')->get();
        $equipos      = Equipo::activos()->orderBy('nombre')->get();
        $criticidades = CriticidadMantenimiento::activos()->ordenadas()->get();

        return view('gestion.mantenimientos.edit', compact(
            'mantenimiento',
            'inmuebles',
            'equipos',
            'criticidades'
        ));
    }

    public function update(UpdateMantenimientoRequest $request, Mantenimiento $mantenimiento): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $data['activo_type'] = $data['tipo_activo'] === 'inmueble'
                ? 'App\\Models\\Inmueble'
                : 'App\\Models\\Equipo';

            // Detectar si cambió el estado antes de actualizar
            $estadoAnterior = $mantenimiento->estado;
            $estadoNuevo    = $data['estado'];

            $mantenimiento->update($data);

            // Si cambió el estado, registrar en el historial
            if ($estadoAnterior !== $estadoNuevo) {
                $user = auth()->user();
                $mantenimiento->historial()->create([
                    'estado_anterior' => $estadoAnterior,
                    'estado_nuevo'    => $estadoNuevo,
                    'comentario'      => 'Cambio de estado desde el formulario de edición.',
                    'costo_real'      => null,
                    'user_id'         => $user?->id,
                    'user_nombre'     => $user?->full_name,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('gestion.mantenimientos.index')
                ->with('success', 'Mantenimiento actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el mantenimiento: ' . $e->getMessage());
        }
    }

    // ══════════════════════════════════════════════════════════════
    //  ELIMINAR
    // ══════════════════════════════════════════════════════════════

    public function destroy(Mantenimiento $mantenimiento): RedirectResponse
    {
        try {
            $mantenimiento->delete();

            return redirect()
                ->route('gestion.mantenimientos.index')
                ->with('success', 'Mantenimiento eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el mantenimiento: ' . $e->getMessage());
        }
    }

    // ══════════════════════════════════════════════════════════════
    //  MODAL DE COMPLETAR
    // ══════════════════════════════════════════════════════════════

    /**
     * Muestra la vista/formulario del modal "Completar mantenimiento".
     * (Puede ser el mismo show con el modal embebido; si quieres endpoint dedicado:)
     */
    public function completarForm(Mantenimiento $mantenimiento): View
    {
        $mantenimiento->load(['criticidadMantenimiento', 'activoRelacionado']);

        $inmuebles    = Inmueble::activos()->orderBy('nombre')->get();
        $equipos      = Equipo::activos()->orderBy('nombre')->get();
        $periodicidades = PeriodicidadMantenimiento::activos()->ordenadas()->get();
        $criticidades = CriticidadMantenimiento::activos()->ordenadas()->get();

        return view('gestion.mantenimientos.completar', compact(
            'mantenimiento',
            'inmuebles',
            'equipos',
            'periodicidades',
            'criticidades'
        ));
    }

    /**
     * Procesa el modal "Completar mantenimiento".
     * - Cambia el estado a completado.
     * - Guarda costo_real, comentario.
     * - Adjunta documentos (orden de compra, etc.).
     * - Opcionalmente crea un nuevo mantenimiento programado.
     * - Opcionalmente registra la garantía del trabajo, asociada a este mantenimiento y su activo.
     */
    public function completar(Request $request, Mantenimiento $mantenimiento): RedirectResponse
    {
        $validated = $request->validate([
            'costo_real'      => 'required|numeric|min:0|max:9999999999999.99',
            'comentario'      => 'nullable|string',

            // Documentos (array de archivos)
            'documentos'      => 'nullable|array',
            'documentos.*'    => 'file|max:10240', // 10 MB por archivo
            'tipos_documentos' => 'nullable|array',
            'tipos_documentos.*' => 'nullable|in:orden_compra,factura,evidencia_fotografica,acta,otro',

            // Programar nuevo mantenimiento (opcional)
            'programar_nuevo'         => 'sometimes|boolean',
            'nuevo_tipo_mantenimiento' => 'required_if:programar_nuevo,1|nullable|in:preventivo,correctivo,predictivo',
            'nuevo_fecha_programada'  => 'required_if:programar_nuevo,1|nullable|date',
            'nuevo_descripcion'       => 'nullable|string',
            'nuevo_periodicidad_id'   => 'nullable|integer|exists:periodicidades_mantenimiento,id',

            // Registrar garantía del trabajo realizado (opcional)
            'registrar_garantia'      => 'sometimes|boolean',
            'garantia_proveedor'      => 'nullable|string|max:200',
            'garantia_fecha_inicio'   => 'required_if:registrar_garantia,1|nullable|date',
            'garantia_fecha_fin'      => 'required_if:registrar_garantia,1|nullable|date|after_or_equal:garantia_fecha_inicio',
            'garantia_monto'          => 'nullable|numeric|min:0',
            'garantia_estado'         => 'required_if:registrar_garantia,1|nullable|in:activa,en_tramite',
            'garantia_terminos'       => 'nullable|string',
        ], [
            'costo_real.required'               => 'El costo real es obligatorio.',
            'costo_real.numeric'                => 'El costo real debe ser un valor numérico.',
            'documentos.*.max'                  => 'Cada documento puede pesar máximo 10 MB.',
            'nuevo_tipo_mantenimiento.required_if' => 'Seleccione el tipo del nuevo mantenimiento.',
            'nuevo_fecha_programada.required_if'   => 'Indique la fecha del nuevo mantenimiento.',
            'garantia_fecha_inicio.required_if' => 'Indique la fecha de inicio de la garantía.',
            'garantia_fecha_fin.required_if'    => 'Indique la fecha de fin de la garantía.',
            'garantia_fecha_fin.after_or_equal' => 'La fecha fin de la garantía debe ser igual o posterior a la de inicio.',
            'garantia_estado.required_if'       => 'Seleccione el estado de la garantía.',
            'garantia_monto.numeric'            => 'El monto de la garantía debe ser un valor numérico.',
        ]);

        try {
            DB::beginTransaction();

            // 1. Cambiar estado a completado usando el helper del modelo
            $mantenimiento->cambiarEstado('completado', [
                'costo_real' => $validated['costo_real'],
                'comentario' => $validated['comentario'] ?? 'Mantenimiento completado.',
            ]);

            // 2. Guardar documentos adjuntos
            if ($request->hasFile('documentos')) {
                $tipos = $request->input('tipos_documentos', []);

                foreach ($request->file('documentos') as $index => $file) {
                    if (!$file->isValid()) {
                        continue;
                    }

                    $path = $file->store("mantenimientos/{$mantenimiento->id}", 'public');

                    MantenimientoDocumento::create([
                        'mantenimiento_id' => $mantenimiento->id,
                        'tipo'             => $tipos[$index] ?? 'otro',
                        'nombre_original'  => $file->getClientOriginalName(),
                        'ruta'             => $path,
                        'mime_type'        => $file->getClientMimeType(),
                        'tamano_bytes'     => $file->getSize(),
                        'descripcion'      => null,
                        'user_id'          => auth()->id(),
                    ]);
                }
            }

            // 3. Programar nuevo mantenimiento (opcional)
            $nuevoMantenimiento = null;
            if ($request->boolean('programar_nuevo')) {
                $nuevoMantenimiento = Mantenimiento::create([
                    'tipo_activo'           => $mantenimiento->tipo_activo,
                    'activo_id'             => $mantenimiento->activo_id,
                    'activo_type'           => $mantenimiento->activo_type,
                    'tipo_mantenimiento'    => $validated['nuevo_tipo_mantenimiento'],
                    'criterio_mantenimiento' => $mantenimiento->criterio_mantenimiento,
                    'criticidad_mantenimiento_id' => $mantenimiento->criticidad_mantenimiento_id,
                    'descripcion'           => $validated['nuevo_descripcion'] ?? 'Mantenimiento programado automáticamente.',
                    'fecha_programada'      => $validated['nuevo_fecha_programada'],
                    'responsable'           => $mantenimiento->responsable,
                    'tipo_responsable'      => $mantenimiento->tipo_responsable,
                    'estado'                => 'programado',
                    'periodicidad_mantenimiento_id' => $validated['nuevo_periodicidad_id'] ?? null,
                    'activo'                => true,
                ]);

                // Registrar creación del nuevo mantenimiento en su historial
                $nuevoMantenimiento->historial()->create([
                    'estado_anterior' => null,
                    'estado_nuevo'    => 'programado',
                    'comentario'      => "Programado automáticamente al completar {$mantenimiento->codigo}.",
                    'user_id'         => auth()->id(),
                    'user_nombre'     => auth()->user()?->full_name,
                ]);
            }

            // 4. Registrar garantía del trabajo realizado (opcional)
            $garantia = null;
            if ($request->boolean('registrar_garantia')) {
                $garantia = Garantia::create([
                    'mantenimiento_id' => $mantenimiento->id,
                    'tipo_activo'      => $mantenimiento->tipo_activo,
                    'activo_id'        => $mantenimiento->activo_id,
                    'proveedor'        => $validated['garantia_proveedor'] ?? $mantenimiento->empresa_contratista,
                    'fecha_inicio'     => $validated['garantia_fecha_inicio'],
                    'fecha_fin'        => $validated['garantia_fecha_fin'],
                    'monto'            => $validated['garantia_monto'] ?? null,
                    'estado'           => $validated['garantia_estado'],
                    'terminos'         => $validated['garantia_terminos'] ?? null,
                    'activo'           => true,
                ]);
            }

            DB::commit();

            $msg = 'Mantenimiento completado exitosamente.';
            if ($nuevoMantenimiento) {
                $msg .= " Se programó el nuevo mantenimiento {$nuevoMantenimiento->codigo}.";
            }
            if ($garantia) {
                $msg .= " Se registró la garantía {$garantia->codigo}.";
            }

            return redirect()
                ->route('gestion.mantenimientos.show', $mantenimiento)
                ->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al completar el mantenimiento: ' . $e->getMessage());
        }
    }

    // ══════════════════════════════════════════════════════════════
    //  CALENDARIO
    // ══════════════════════════════════════════════════════════════

    public function calendario(): View
    {
        $hoy = now()->startOfDay();

        $pendientes = Mantenimiento::activos()
            ->whereIn('estado', ['programado', 'en_proceso'])
            ->whereNotNull('fecha_programada');

        // Próximos 30 días (incluye hoy)
        $proximos = (clone $pendientes)
            ->whereBetween('fecha_programada', [$hoy, $hoy->copy()->addDays(30)])
            ->with('activoRelacionado')
            ->orderBy('fecha_programada')
            ->limit(8)
            ->get();

        $totalVencidos = (clone $pendientes)
            ->where('fecha_programada', '<', $hoy)
            ->count();

        $totalMes = Mantenimiento::activos()
            ->whereBetween('fecha_programada', [$hoy->copy()->startOfMonth(), $hoy->copy()->endOfMonth()])
            ->count();

        return view('gestion.mantenimientos.calendario', compact('proximos', 'totalVencidos', 'totalMes'));
    }

    /**
     * Eventos para FullCalendar. Recibe start/end (ISO) del rango visible
     * y los filtros opcionales tipo_mantenimiento, estado y tipo_activo.
     */
    public function calendarioEventos(Request $request): JsonResponse
    {
        $request->validate([
            'start'              => 'required|date',
            'end'                => 'required|date|after:start',
            'tipo_mantenimiento' => 'nullable|in:preventivo,correctivo,predictivo',
            'estado'             => 'nullable|in:programado,en_proceso,completado,cancelado',
            'tipo_activo'        => 'nullable|in:inmueble,equipo',
        ]);

        $hoy = now()->startOfDay();

        $mantenimientos = Mantenimiento::activos()
            ->whereNotNull('fecha_programada')
            ->where('fecha_programada', '>=', substr($request->start, 0, 10))
            ->where('fecha_programada', '<', substr($request->end, 0, 10))
            ->when($request->filled('tipo_mantenimiento'), fn ($q) => $q->where('tipo_mantenimiento', $request->tipo_mantenimiento))
            ->when($request->filled('estado'), fn ($q) => $q->where('estado', $request->estado))
            ->when($request->filled('tipo_activo'), fn ($q) => $q->where('tipo_activo', $request->tipo_activo))
            ->with(['activoRelacionado', 'criticidadMantenimiento'])
            ->orderBy('fecha_programada')
            ->get();

        $eventos = $mantenimientos->map(function (Mantenimiento $m) use ($hoy) {
            $vencido = in_array($m->estado, ['programado', 'en_proceso'])
                && $m->fecha_programada->lt($hoy);

            return [
                'id'        => $m->id,
                'title'     => $m->codigo . ' · ' . $m->nombre_activo,
                'start'     => $m->fecha_programada->format('Y-m-d'),
                'allDay'    => true,
                'url'       => route('gestion.mantenimientos.show', $m),
                'classNames' => ['evento-mant', 'evento-mant--' . ($vencido ? 'vencido' : $m->estado)],
                'extendedProps' => [
                    'tipo'        => $m->tipo_mantenimiento,
                    'estado'      => $m->estado,
                    'vencido'     => $vencido,
                    'criticidad'  => $m->criticidadMantenimiento?->nombre,
                    'responsable' => $m->responsable,
                    'descripcion' => $m->descripcion,
                ],
            ];
        });

        return response()->json($eventos);
    }

    // ══════════════════════════════════════════════════════════════
    //  API: Activos por tipo (ya existía)
    // ══════════════════════════════════════════════════════════════

    public function activosPorTipo(Request $request): JsonResponse
    {
        if ($request->tipo === 'inmueble') {
            $activos = Inmueble::activos()->orderBy('nombre')->get(['id', 'codigo', 'nombre']);
        } else {
            $activos = Equipo::activos()->orderBy('nombre')->get(['id', 'codigo', 'nombre']);
        }

        return response()->json($activos);
    }

    // ══════════════════════════════════════════════════════════════
    //  API: Criticidades por criterio (para select dependiente)
    // ══════════════════════════════════════════════════════════════

    /**
     * Devuelve las criticidades disponibles para el criterio indicado.
     * Se puede personalizar según el criterio (ej. distintos niveles según el riesgo),
     * pero por defecto devuelve todas las activas ordenadas.
     */
    public function criticidadesPorCriterio(Request $request): JsonResponse
    {
        $criterio = $request->get('criterio');

        // Ejemplo de personalización (opcional):
        // - Riesgo de vida → solo Grave y Moderado
        // - Riesgo operacional → Moderado y Leve
        // - Riesgo sancionatorio → Grave y Moderado
        // - Riesgo sobre activo → todos
        $query = CriticidadMantenimiento::activos()->ordenadas();

       /*  if ($criterio === 'riesgo_vida' || $criterio === 'riesgo_sancionatorio') {
            $query->whereIn('codigo', ['GRAVE', 'MODERADO']);
        } elseif ($criterio === 'riesgo_operacional') {
            $query->whereIn('codigo', ['MODERADO', 'LEVE']);
        } */
        // 'riesgo_activo' → todas

        return response()->json($query->get(['id', 'nombre', 'codigo', 'color_hex', 'nivel']));
    }

    // ══════════════════════════════════════════════════════════════
    //  PRESUPUESTO
    // ══════════════════════════════════════════════════════════════

    public function presupuesto(Request $request): View
    {
        $anio = $request->get('anio', now()->year);
        $tipoActivo = $request->get('tipo_activo');
        $tipoMantenimiento = $request->get('tipo_mantenimiento');
        $tipoResponsable = $request->get('tipo_responsable');

        // ══════════════════════════════════════════════════════════════════
        //  1. PRESUPUESTO (Presupuesto Aprobado) → programados + en_proceso
        // ══════════════════════════════════════════════════════════════════
        $queryPresupuesto = Mantenimiento::activos()
            ->whereIn('estado', ['programado', 'en_proceso'])
            ->whereYear('fecha_programada', $anio)
            ->when($tipoActivo, fn($q) => $q->where('tipo_activo', $tipoActivo))
            ->when($tipoMantenimiento, fn($q) => $q->where('tipo_mantenimiento', $tipoMantenimiento))
            ->when($tipoResponsable, fn($q) => $q->where('tipo_responsable', $tipoResponsable))
            ->with(['criticidadMantenimiento', 'activoRelacionado'])
            ->orderBy('fecha_programada');

        $mantenimientosPresupuesto = $queryPresupuesto->get();

        $porMesPresupuesto = $mantenimientosPresupuesto->groupBy(fn($i) => $i->fecha_programada->format('m'))->sortKeys();
        $totalesPorMesPresupuesto = $porMesPresupuesto->map(fn($items) => $items->sum('presupuesto_aprobado'));
        $totalAnualPresupuesto = $mantenimientosPresupuesto->sum('presupuesto_aprobado');

        $totalesPorTipoPresupuesto = $mantenimientosPresupuesto->groupBy('tipo_mantenimiento')
            ->map(fn($items) => ['total' => $items->sum('presupuesto_aprobado'), 'count' => $items->count()]);

        $totalesPorResponsablePresupuesto = $mantenimientosPresupuesto->groupBy('tipo_responsable')
            ->map(fn($items) => ['total' => $items->sum('presupuesto_aprobado'), 'count' => $items->count()]);

        $totalesPorActivoPresupuesto = $mantenimientosPresupuesto->groupBy('tipo_activo')
            ->map(fn($items) => ['total' => $items->sum('presupuesto_aprobado'), 'count' => $items->count()]);

        // ══════════════════════════════════════════════════════════════════
        //  2. EJECUTADO (Costo Real) → completados
        // ══════════════════════════════════════════════════════════════════
        $queryEjecutado = Mantenimiento::activos()
            ->where('estado', 'completado')
            ->whereYear('fecha_programada', $anio)
            ->when($tipoActivo, fn($q) => $q->where('tipo_activo', $tipoActivo))
            ->when($tipoMantenimiento, fn($q) => $q->where('tipo_mantenimiento', $tipoMantenimiento))
            ->when($tipoResponsable, fn($q) => $q->where('tipo_responsable', $tipoResponsable))
            ->with(['criticidadMantenimiento', 'activoRelacionado'])
            ->orderBy('fecha_programada');

        $mantenimientosEjecutado = $queryEjecutado->get();

        $porMesEjecutado = $mantenimientosEjecutado->groupBy(fn($i) => $i->fecha_programada->format('m'))->sortKeys();
        $totalesPorMesEjecutado = $porMesEjecutado->map(fn($items) => $items->sum('costo_real'));
        $totalAnualEjecutado = $mantenimientosEjecutado->sum('costo_real');

        $totalesPorTipoEjecutado = $mantenimientosEjecutado->groupBy('tipo_mantenimiento')
            ->map(fn($items) => ['total' => $items->sum('costo_real'), 'count' => $items->count()]);

        $totalesPorResponsableEjecutado = $mantenimientosEjecutado->groupBy('tipo_responsable')
            ->map(fn($items) => ['total' => $items->sum('costo_real'), 'count' => $items->count()]);

        $totalesPorActivoEjecutado = $mantenimientosEjecutado->groupBy('tipo_activo')
            ->map(fn($items) => ['total' => $items->sum('costo_real'), 'count' => $items->count()]);

        // ══════════════════════════════════════════════════════════════════
        //  3. Comparativa (Aprobado vs Real) por mes
        // ══════════════════════════════════════════════════════════════════
        $comparativaPorMes = collect(range(1, 12))->mapWithKeys(function ($mes) use ($totalesPorMesPresupuesto, $totalesPorMesEjecutado) {
            $mesStr = str_pad($mes, 2, '0', STR_PAD_LEFT);
            $aprobado = $totalesPorMesPresupuesto[$mesStr] ?? 0;
            $real  = $totalesPorMesEjecutado[$mesStr] ?? 0;
            return [$mesStr => [
                'aprobado' => $aprobado,
                'real'  => $real,
                'desviacion' => $real - $aprobado,
            ]];
        });

        // ══════════════════════════════════════════════════════════════════
        //  Filtros auxiliares
        // ══════════════════════════════════════════════════════════════════
        $aniosDisponibles = Mantenimiento::activos()
            ->selectRaw('EXTRACT(YEAR FROM fecha_programada) as anio')
            ->whereNotNull('fecha_programada')
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');

        $responsablesDisponibles = [
            'Mincit',
            'Operador ZFP',
            'Subarrendatario',
            'Usuario-calificado'
        ];

        return view('gestion.mantenimientos.presupuesto', compact(
            // Presupuesto (aprobado)
            'mantenimientosPresupuesto',
            'porMesPresupuesto',
            'totalesPorMesPresupuesto',
            'totalAnualPresupuesto',
            'totalesPorTipoPresupuesto',
            'totalesPorResponsablePresupuesto',
            'totalesPorActivoPresupuesto',
            // Ejecutado (real)
            'mantenimientosEjecutado',
            'porMesEjecutado',
            'totalesPorMesEjecutado',
            'totalAnualEjecutado',
            'totalesPorTipoEjecutado',
            'totalesPorResponsableEjecutado',
            'totalesPorActivoEjecutado',
            // Comparativa
            'comparativaPorMes',
            // Filtros
            'aniosDisponibles',
            'responsablesDisponibles',
            'anio',
            'tipoActivo',
            'tipoMantenimiento',
            'tipoResponsable'
        ));
    }
}
