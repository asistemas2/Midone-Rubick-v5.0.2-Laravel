<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametrizacion\StoreEstadoEquipoRequest;
use App\Http\Requests\Parametrizacion\UpdateEstadoEquipoRequest;
use App\Models\EstadoEquipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstadoEquipoController extends Controller
{
    /**
     * Mostrar listado paginado de estados de equipo.
     */
    public function index(Request $request): View
    {
        $estados = EstadoEquipo::activos()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%')
                      ->orWhere('codigo', 'like', '%' . $request->buscar . '%');
            })
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('parametrizacion.estados_equipo.index', compact('estados'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create(): View
    {
        return view('parametrizacion.estados_equipo.create');
    }

    /**
     * Almacenar un nuevo estado de equipo.
     */
    public function store(StoreEstadoEquipoRequest $request): RedirectResponse
    {
        try {
            EstadoEquipo::create($request->validated());

            return redirect()
                ->route('parametrizacion.estados_equipo.index')
                ->with('success', 'Estado de equipo creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el estado de equipo: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de un estado de equipo.
     */
    public function show(EstadoEquipo $estados_equipo): View
    {
        return view('parametrizacion.estados_equipo.show', ['estado' => $estados_equipo]);
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(EstadoEquipo $estados_equipo): View
    {
        return view('parametrizacion.estados_equipo.edit', ['estado' => $estados_equipo]);
    }

    /**
     * Actualizar un estado de equipo existente.
     */
    public function update(UpdateEstadoEquipoRequest $request, EstadoEquipo $estados_equipo): RedirectResponse
    {
        try {
            $estados_equipo->update($request->validated());

            return redirect()
                ->route('parametrizacion.estados_equipo.index')
                ->with('success', 'Estado de equipo actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el estado de equipo: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar (soft delete) un estado de equipo.
     */
    public function destroy(EstadoEquipo $estados_equipo): RedirectResponse
    {
        try {
            $estados_equipo->delete();

            return redirect()
                ->route('parametrizacion.estados_equipo.index')
                ->with('success', 'Estado de equipo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el estado de equipo: ' . $e->getMessage());
        }
    }
}
