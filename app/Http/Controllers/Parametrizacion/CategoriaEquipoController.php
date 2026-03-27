<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametrizacion\StoreCategoriaEquipoRequest;
use App\Http\Requests\Parametrizacion\UpdateCategoriaEquipoRequest;
use App\Models\CategoriaEquipo;
use App\Models\TipoEquipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaEquipoController extends Controller
{
    /**
     * Mostrar listado paginado de categorías de equipo.
     */
    public function index(Request $request): View
    {
        $categorias = CategoriaEquipo::activos()
            ->with('tipoEquipo')
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%');
            })
            ->when($request->filled('tipo_equipo_id'), function ($query) use ($request) {
                $query->where('tipo_equipo_id', $request->tipo_equipo_id);
            })
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        $tiposEquipo = TipoEquipo::activos()->orderBy('nombre')->get();

        return view('parametrizacion.categorias_equipo.index', compact('categorias', 'tiposEquipo'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create(): View
    {
        $tiposEquipo = TipoEquipo::activos()->orderBy('nombre')->get();

        return view('parametrizacion.categorias_equipo.create', compact('tiposEquipo'));
    }

    /**
     * Almacenar una nueva categoría de equipo.
     */
    public function store(StoreCategoriaEquipoRequest $request): RedirectResponse
    {
        try {
            CategoriaEquipo::create($request->validated());

            return redirect()
                ->route('parametrizacion.categorias_equipo.index')
                ->with('success', 'Categoría de equipo creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear la categoría de equipo: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de una categoría de equipo.
     */
    public function show(CategoriaEquipo $categorias_equipo): View
    {
        $categorias_equipo->load('tipoEquipo');

        return view('parametrizacion.categorias_equipo.show', ['categoria' => $categorias_equipo]);
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(CategoriaEquipo $categorias_equipo): View
    {
        $tiposEquipo = TipoEquipo::activos()->orderBy('nombre')->get();

        return view('parametrizacion.categorias_equipo.edit', [
            'categoria'   => $categorias_equipo,
            'tiposEquipo' => $tiposEquipo,
        ]);
    }

    /**
     * Actualizar una categoría de equipo existente.
     */
    public function update(UpdateCategoriaEquipoRequest $request, CategoriaEquipo $categorias_equipo): RedirectResponse
    {
        try {
            $categorias_equipo->update($request->validated());

            return redirect()
                ->route('parametrizacion.categorias_equipo.index')
                ->with('success', 'Categoría de equipo actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar la categoría de equipo: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar (soft delete) una categoría de equipo.
     */
    public function destroy(CategoriaEquipo $categorias_equipo): RedirectResponse
    {
        try {
            $categorias_equipo->delete();

            return redirect()
                ->route('parametrizacion.categorias_equipo.index')
                ->with('success', 'Categoría de equipo eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar la categoría de equipo: ' . $e->getMessage());
        }
    }
}
