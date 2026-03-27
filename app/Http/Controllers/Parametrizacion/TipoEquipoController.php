<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametrizacion\StoreTipoEquipoRequest;
use App\Http\Requests\Parametrizacion\UpdateTipoEquipoRequest;
use App\Models\TipoEquipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TipoEquipoController extends Controller
{
    /**
     * Mostrar listado paginado de tipos de equipo.
     */
    public function index(Request $request): View
    {
        $tiposEquipo = TipoEquipo::activos()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%');
            })
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('parametrizacion.tipos_equipo.index', compact('tiposEquipo'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create(): View
    {
        return view('parametrizacion.tipos_equipo.create');
    }

    /**
     * Almacenar un nuevo tipo de equipo.
     */
    public function store(StoreTipoEquipoRequest $request): RedirectResponse
    {
        try {
            TipoEquipo::create($request->validated());

            return redirect()
                ->route('parametrizacion.tipos_equipo.index')
                ->with('success', 'Tipo de equipo creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el tipo de equipo: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de un tipo de equipo.
     */
    public function show(TipoEquipo $tipos_equipo): View
    {
        $tipos_equipo->load('categorias');

        return view('parametrizacion.tipos_equipo.show', ['tipoEquipo' => $tipos_equipo]);
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(TipoEquipo $tipos_equipo): View
    {
        return view('parametrizacion.tipos_equipo.edit', ['tipoEquipo' => $tipos_equipo]);
    }

    /**
     * Actualizar un tipo de equipo existente.
     */
    public function update(UpdateTipoEquipoRequest $request, TipoEquipo $tipos_equipo): RedirectResponse
    {
        try {
            $tipos_equipo->update($request->validated());

            return redirect()
                ->route('parametrizacion.tipos_equipo.index')
                ->with('success', 'Tipo de equipo actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el tipo de equipo: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar (soft delete) un tipo de equipo.
     */
    public function destroy(TipoEquipo $tipos_equipo): RedirectResponse
    {
        try {
            $tipos_equipo->delete();

            return redirect()
                ->route('parametrizacion.tipos_equipo.index')
                ->with('success', 'Tipo de equipo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el tipo de equipo: ' . $e->getMessage());
        }
    }
}
