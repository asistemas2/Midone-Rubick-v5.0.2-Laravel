<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gestion\StoreAsignacionEquipoRequest;
use App\Http\Requests\Gestion\UpdateAsignacionEquipoRequest;
use App\Models\Equipo;
use App\Models\Inmueble;
use App\Models\TipoEquipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AsignacionEquipoController extends Controller
{
    public function index(Request $request): View
    {
        $equipos = Equipo::activos()
            ->with(['tipoEquipo', 'categoriaEquipo', 'marca', 'estadoEquipo', 'inmueble.bloque'])
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('nombre', 'like', '%' . $request->buscar . '%')
                      ->orWhere('codigo', 'like', '%' . $request->buscar . '%');
                });
            })
            ->when($request->filled('inmueble_id'), function ($query) use ($request) {
                $query->where('inmueble_id', $request->inmueble_id);
            })
            ->when($request->filled('tipo_equipo_id'), function ($query) use ($request) {
                $query->where('tipo_equipo_id', $request->tipo_equipo_id);
            })
            ->when($request->filled('estado_asignacion'), function ($query) use ($request) {
                if ($request->estado_asignacion === 'asignado') {
                    $query->whereNotNull('inmueble_id');
                } elseif ($request->estado_asignacion === 'sin_asignar') {
                    $query->whereNull('inmueble_id');
                }
            })
            ->orderBy('codigo')
            ->paginate(15)
            ->withQueryString();

        // Estadísticas
        $totalEquipos = Equipo::activos()->count();
        $asignados = Equipo::activos()->whereNotNull('inmueble_id')->count();
        $sinAsignar = $totalEquipos - $asignados;
        $porcentajeAsignacion = $totalEquipos > 0 ? round(($asignados / $totalEquipos) * 100, 1) : 0;

        // Datos para filtros
        $inmuebles = Inmueble::activos()->orderBy('nombre')->get();
        $tiposEquipo = TipoEquipo::activos()->orderBy('nombre')->get();

        return view('gestion.asignaciones.index', compact(
            'equipos', 'inmuebles', 'tiposEquipo',
            'totalEquipos', 'asignados', 'sinAsignar', 'porcentajeAsignacion'
        ), [
             'layout' => 'top-menu'
            // Specify the base layout.
            // Eg: 'side-menu', 'simple-menu', 'top-menu', 'login'
            // The default value is 'side-menu'

            // 'layout' => 'side-menu'
        ]);
    }

    public function create(Request $request): View
    {
        $equiposSinAsignar = Equipo::activos()
            ->whereNull('inmueble_id')
            ->with(['tipoEquipo', 'categoriaEquipo', 'marca'])
            ->orderBy('codigo')
            ->get();

        $inmuebles = Inmueble::activos()
            ->with(['bloque', 'tipoInmueble'])
            ->withCount('equipos')
            ->orderBy('nombre')
            ->get();

        // Pre-seleccionar equipo si viene por parámetro
        $equipoSeleccionado = $request->filled('equipo_id')
            ? Equipo::find($request->equipo_id)
            : null;

        return view('gestion.asignaciones.create', compact(
            'equiposSinAsignar', 'inmuebles', 'equipoSeleccionado'
        ));
    }

    public function store(StoreAsignacionEquipoRequest $request): RedirectResponse
    {
        try {
            $equipo = Equipo::findOrFail($request->equipo_id);
            $equipo->update(['inmueble_id' => $request->inmueble_id]);

            return redirect()
                ->route('gestion.asignaciones.index')
                ->with('success', 'Equipo "' . $equipo->nombre . '" asignado exitosamente al inmueble.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al asignar el equipo: ' . $e->getMessage());
        }
    }

    public function show(Equipo $asignacione): View
    {
        $equipo = $asignacione;
        $equipo->load([
            'tipoEquipo', 'categoriaEquipo', 'marca', 'estadoEquipo',
            'criticidad', 'inmueble.bloque', 'inmueble.tipoInmueble',
            'inmueble.equipos' => function ($query) use ($equipo) {
                $query->where('id', '!=', $equipo->id)->activos()->with('tipoEquipo');
            },
        ]);

        return view('gestion.asignaciones.show', compact('equipo'));
    }

    public function edit(Equipo $asignacione): View
    {
        $equipo = $asignacione;
        $equipo->load(['tipoEquipo', 'categoriaEquipo', 'marca', 'inmueble']);

        $inmuebles = Inmueble::activos()
            ->with(['bloque', 'tipoInmueble'])
            ->withCount('equipos')
            ->orderBy('nombre')
            ->get();

        return view('gestion.asignaciones.edit', compact('equipo', 'inmuebles'));
    }

    public function update(UpdateAsignacionEquipoRequest $request, Equipo $asignacione): RedirectResponse
    {
        try {
            $equipo = $asignacione;
            $equipo->update(['inmueble_id' => $request->inmueble_id]);

            return redirect()
                ->route('gestion.asignaciones.index')
                ->with('success', 'Asignación del equipo "' . $equipo->nombre . '" actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar la asignación: ' . $e->getMessage());
        }
    }

    public function destroy(Equipo $asignacione): RedirectResponse
    {
        try {
            $equipo = $asignacione;
            $nombreEquipo = $equipo->nombre;
            $equipo->update(['inmueble_id' => null]);

            return redirect()
                ->route('gestion.asignaciones.index')
                ->with('success', 'Equipo "' . $nombreEquipo . '" desasignado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al desasignar el equipo: ' . $e->getMessage());
        }
    }
}
