<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gestion\StoreMantenimientoRequest;
use App\Http\Requests\Gestion\UpdateMantenimientoRequest;
use App\Models\Mantenimiento;
use App\Models\Inmueble;
use App\Models\Equipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class MantenimientoController extends Controller
{
    public function index(Request $request): View
    {
        $mantenimientos = Mantenimiento::activos()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('codigo', 'like', '%' . $request->buscar . '%')
                      ->orWhere('descripcion', 'like', '%' . $request->buscar . '%');
            })
            ->when($request->filled('estado'), function ($query) use ($request) {
                $query->where('estado', $request->estado);
            })
            ->when($request->filled('tipo_activo'), function ($query) use ($request) {
                $query->where('tipo_activo', $request->tipo_activo);
            })
            ->when($request->filled('tipo_mantenimiento'), function ($query) use ($request) {
                $query->where('tipo_mantenimiento', $request->tipo_mantenimiento);
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

        return view('gestion.mantenimientos.index', compact('mantenimientos'));
    }

    public function create(): View
    {
        $inmuebles = Inmueble::activos()->orderBy('nombre')->get();
        $equipos = Equipo::activos()->orderBy('nombre')->get();

        return view('gestion.mantenimientos.create', compact('inmuebles', 'equipos'));
    }

    public function store(StoreMantenimientoRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Asignar activo_type según tipo_activo
            $data['activo_type'] = $data['tipo_activo'] === 'inmueble'
                ? 'App\\Models\\Inmueble'
                : 'App\\Models\\Equipo';

            Mantenimiento::create($data);

            return redirect()
                ->route('gestion.mantenimientos.index')
                ->with('success', 'Mantenimiento creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el mantenimiento: ' . $e->getMessage());
        }
    }

    public function show(Mantenimiento $mantenimiento): View
    {
        $mantenimiento->load(['garantias']);

        return view('gestion.mantenimientos.show', compact('mantenimiento'));
    }

    public function edit(Mantenimiento $mantenimiento): View
    {
        $inmuebles = Inmueble::activos()->orderBy('nombre')->get();
        $equipos = Equipo::activos()->orderBy('nombre')->get();

        return view('gestion.mantenimientos.edit', compact('mantenimiento', 'inmuebles', 'equipos'));
    }

    public function update(UpdateMantenimientoRequest $request, Mantenimiento $mantenimiento): RedirectResponse
    {
        try {
            $data = $request->validated();

            $data['activo_type'] = $data['tipo_activo'] === 'inmueble'
                ? 'App\\Models\\Inmueble'
                : 'App\\Models\\Equipo';

            $mantenimiento->update($data);

            return redirect()
                ->route('gestion.mantenimientos.index')
                ->with('success', 'Mantenimiento actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el mantenimiento: ' . $e->getMessage());
        }
    }

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

    /**
     * API: Obtener activos según tipo.
     */
    public function activosPorTipo(Request $request): JsonResponse
    {
        if ($request->tipo === 'inmueble') {
            $activos = Inmueble::activos()->orderBy('nombre')->get(['id', 'codigo', 'nombre']);
        } else {
            $activos = Equipo::activos()->orderBy('nombre')->get(['id', 'codigo', 'nombre']);
        }

        return response()->json($activos);
    }
}
