<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gestion\StoreInmuebleRequest;
use App\Http\Requests\Gestion\UpdateInmuebleRequest;
use App\Models\Inmueble;
use App\Models\Bloque;
use App\Models\TipoInmueble;
use App\Models\NivelDeterioro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class InmuebleController extends Controller
{
    public function index(Request $request): View
    {
        $inmuebles = Inmueble::activos()
            ->with(['bloque', 'tipoInmueble', 'nivelDeterioro'])
            ->buscar(['nombre', 'codigo'], $request->buscar)
            ->when($request->filled('estado'), function ($query) use ($request) {
                $query->where('estado', $request->estado);
            })
            ->when($request->filled('bloque_id'), function ($query) use ($request) {
                $query->where('bloque_id', $request->bloque_id);
            })
            ->when($request->filled('tipo_inmueble_id'), function ($query) use ($request) {
                $query->where('tipo_inmueble_id', $request->tipo_inmueble_id);
            })
            ->orderBy('codigo')
            ->paginate(15)
            ->withQueryString();

        $bloques = Bloque::activos()->orderBy('nombre')->get();
        $tiposInmueble = TipoInmueble::activos()->orderBy('nombre')->get();

        return view('gestion.inmuebles.index', compact('inmuebles', 'bloques', 'tiposInmueble'));
    }

    public function create(): View
    {
        $bloques = Bloque::activos()->orderBy('nombre')->get();
        $tiposInmueble = TipoInmueble::activos()->orderBy('nombre')->get();
        $nivelesDeterioro = NivelDeterioro::activos()->ordenados()->get();

        return view('gestion.inmuebles.create', compact('bloques', 'tiposInmueble', 'nivelesDeterioro'));
    }

    public function store(StoreInmuebleRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                $inmueble = Inmueble::create($request->validated());
                $this->guardarFichaTecnica($request, $inmueble);
            });

            return redirect()
                ->route('gestion.inmuebles.index')
                ->with('success', 'Inmueble creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el inmueble: ' . $e->getMessage());
        }
    }

    public function show(Inmueble $inmueble): View
    {
        $inmueble->load([
            'bloque', 'tipoInmueble', 'nivelDeterioro', 'equipos.tipoEquipo', 'fichaTecnica',
            'mantenimientos' => fn ($q) => $q->activos()->orderByDesc('fecha_programada'),
            'garantias' => fn ($q) => $q->activos()->with('mantenimiento')->orderByDesc('fecha_fin'),
        ]);
        return view('gestion.inmuebles.show', compact('inmueble'));
    }


    public function edit(Inmueble $inmueble): View
    {
        $bloques = Bloque::activos()->orderBy('nombre')->get();
        $tiposInmueble = TipoInmueble::activos()->orderBy('nombre')->get();
        $nivelesDeterioro = NivelDeterioro::activos()->ordenados()->get();

        return view('gestion.inmuebles.edit', compact('inmueble', 'bloques', 'tiposInmueble', 'nivelesDeterioro'));
    }

    public function update(UpdateInmuebleRequest $request, Inmueble $inmueble): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $inmueble) {
                $inmueble->update($request->validated());
                $this->guardarFichaTecnica($request, $inmueble);
            });

            return redirect()
                ->route('gestion.inmuebles.index')
                ->with('success', 'Inmueble actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el inmueble: ' . $e->getMessage());
        }
    }

    public function destroy(Inmueble $inmueble): RedirectResponse
    {
        try {
            $inmueble->delete();

            return redirect()
                ->route('gestion.inmuebles.index')
                ->with('success', 'Inmueble eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el inmueble: ' . $e->getMessage());
        }
    }

    /**
     * Guarda la ficha técnica solo si el inmueble es Bodega.
     * Si no lo es, no se toca: una ficha previa se conserva oculta.
     */
    private function guardarFichaTecnica(Request $request, Inmueble $inmueble): void
    {
        if (! $inmueble->load('tipoInmueble')->esBodega()) {
            return;
        }

        $datos = $request->validated('ficha_tecnica') ?? [];

        // Un checkbox desmarcado no se envía: se fuerza el false explícito
        foreach (['muelle', 'mezzanine', 'cocineta'] as $campo) {
            $datos[$campo] = $request->boolean("ficha_tecnica.$campo");
        }

        // No crear fichas vacías
        if (! $inmueble->fichaTecnica()->exists() && ! array_filter($datos)) {
            return;
        }

        $inmueble->fichaTecnica()->updateOrCreate(['inmueble_id' => $inmueble->id], $datos);
    }

    /**
     * API: Obtener coordenadas de todos los inmuebles con ubicación.
     */
    public function coordenadas(): JsonResponse
    {
        $inmuebles = Inmueble::activos()
            ->whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->select('id', 'codigo', 'nombre', 'latitud', 'longitud', 'estado')
            ->get();

        return response()->json($inmuebles);
    }
}
