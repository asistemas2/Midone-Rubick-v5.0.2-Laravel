<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametrizacion\StoreCriticidadRequest;
use App\Http\Requests\Parametrizacion\UpdateCriticidadRequest;
use App\Models\Criticidad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CriticidadController extends Controller
{
    /**
     * Mostrar listado paginado de criticidades.
     */
    public function index(Request $request): View
    {
        $criticidades = Criticidad::activos()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%');
            })
            ->ordenadas()
            ->paginate(15)
            ->withQueryString();

        return view('parametrizacion.criticidades.index', compact('criticidades'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create(): View
    {
        return view('parametrizacion.criticidades.create');
    }

    /**
     * Almacenar una nueva criticidad.
     */
    public function store(StoreCriticidadRequest $request): RedirectResponse
    {
        try {
            Criticidad::create($request->validated());

            return redirect()
                ->route('parametrizacion.criticidades.index')
                ->with('success', 'Criticidad creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear la criticidad: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de una criticidad.
     */
    public function show(Criticidad $criticidade): View
    {
        return view('parametrizacion.criticidades.show', ['criticidad' => $criticidade]);
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Criticidad $criticidade): View
    {
        return view('parametrizacion.criticidades.edit', ['criticidad' => $criticidade]);
    }

    /**
     * Actualizar una criticidad existente.
     */
    public function update(UpdateCriticidadRequest $request, Criticidad $criticidade): RedirectResponse
    {
        try {
            $criticidade->update($request->validated());

            return redirect()
                ->route('parametrizacion.criticidades.index')
                ->with('success', 'Criticidad actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar la criticidad: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar (soft delete) una criticidad.
     */
    public function destroy(Criticidad $criticidade): RedirectResponse
    {
        try {
            $criticidade->delete();

            return redirect()
                ->route('parametrizacion.criticidades.index')
                ->with('success', 'Criticidad eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar la criticidad: ' . $e->getMessage());
        }
    }
}
