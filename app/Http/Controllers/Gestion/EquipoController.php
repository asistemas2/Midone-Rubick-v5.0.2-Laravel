<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gestion\StoreEquipoRequest;
use App\Http\Requests\Gestion\UpdateEquipoRequest;
use App\Models\Equipo;
use App\Models\TipoEquipo;
use App\Models\CategoriaEquipo;
use App\Models\Marca;
use App\Models\EstadoEquipo;
use App\Models\Criticidad;
use App\Models\PeriodicidadMantenimiento;
use App\Models\Inmueble;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class EquipoController extends Controller
{
    public function index(Request $request): View
    {
        $equipos = Equipo::activos()
            ->with(['tipoEquipo', 'categoriaEquipo', 'marca', 'estadoEquipo', 'criticidad'])
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%')
                      ->orWhere('codigo', 'like', '%' . $request->buscar . '%');
            })
            ->when($request->filled('tipo_equipo_id'), function ($query) use ($request) {
                $query->where('tipo_equipo_id', $request->tipo_equipo_id);
            })
            ->when($request->filled('categoria_equipo_id'), function ($query) use ($request) {
                $query->where('categoria_equipo_id', $request->categoria_equipo_id);
            })
            ->when($request->filled('estado_equipo_id'), function ($query) use ($request) {
                $query->where('estado_equipo_id', $request->estado_equipo_id);
            })
            ->when($request->filled('criticidad_id'), function ($query) use ($request) {
                $query->where('criticidad_id', $request->criticidad_id);
            })
            ->orderBy('codigo')
            ->paginate(15)
            ->withQueryString();

        $tiposEquipo = TipoEquipo::activos()->orderBy('nombre')->get();
        $estadosEquipo = EstadoEquipo::activos()->get();
        $criticidades = Criticidad::activos()->ordenadas()->get();

        return view('gestion.equipos.index', compact('equipos', 'tiposEquipo', 'estadosEquipo', 'criticidades'));
    }

    public function create(): View
    {
        $tiposEquipo = TipoEquipo::activos()->orderBy('nombre')->get();
        $categoriasEquipo = CategoriaEquipo::activos()->orderBy('nombre')->get();
        $marcas = Marca::activos()->ordenadas()->get();
        $estadosEquipo = EstadoEquipo::activos()->get();
        $criticidades = Criticidad::activos()->ordenadas()->get();
        $periodicidades = PeriodicidadMantenimiento::activos()->ordenadas()->get();
        $inmuebles = Inmueble::activos()->orderBy('nombre')->get();

        return view('gestion.equipos.create', compact(
            'tiposEquipo', 'categoriasEquipo', 'marcas', 'estadosEquipo',
            'criticidades', 'periodicidades', 'inmuebles'
        ));
    }

    public function store(StoreEquipoRequest $request): RedirectResponse
    {
        try {
            Equipo::create($request->validated());

            return redirect()
                ->route('gestion.equipos.index')
                ->with('success', 'Equipo creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el equipo: ' . $e->getMessage());
        }
    }

    public function show(Equipo $equipo): View
    {
        $equipo->load([
            'tipoEquipo', 'categoriaEquipo', 'marca', 'estadoEquipo',
            'criticidad', 'periodicidadMantenimiento', 'inmueble', 'mantenimientos'
        ]);

        return view('gestion.equipos.show', compact('equipo'));
    }

    public function edit(Equipo $equipo): View
    {
        $tiposEquipo = TipoEquipo::activos()->orderBy('nombre')->get();
        $categoriasEquipo = CategoriaEquipo::activos()->orderBy('nombre')->get();
        $marcas = Marca::activos()->ordenadas()->get();
        $estadosEquipo = EstadoEquipo::activos()->get();
        $criticidades = Criticidad::activos()->ordenadas()->get();
        $periodicidades = PeriodicidadMantenimiento::activos()->ordenadas()->get();
        $inmuebles = Inmueble::activos()->orderBy('nombre')->get();

        return view('gestion.equipos.edit', compact(
            'equipo', 'tiposEquipo', 'categoriasEquipo', 'marcas', 'estadosEquipo',
            'criticidades', 'periodicidades', 'inmuebles'
        ));
    }

    public function update(UpdateEquipoRequest $request, Equipo $equipo): RedirectResponse
    {
        try {
            $equipo->update($request->validated());

            return redirect()
                ->route('gestion.equipos.index')
                ->with('success', 'Equipo actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el equipo: ' . $e->getMessage());
        }
    }

    public function destroy(Equipo $equipo): RedirectResponse
    {
        try {
            $equipo->delete();

            return redirect()
                ->route('gestion.equipos.index')
                ->with('success', 'Equipo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el equipo: ' . $e->getMessage());
        }
    }

    /**
     * API: Categorías por tipo de equipo.
     */
    public function categoriasPorTipo(Request $request): JsonResponse
    {
        $categorias = CategoriaEquipo::activos()
            ->where('tipo_equipo_id', $request->tipo_equipo_id)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json($categorias);
    }
}
