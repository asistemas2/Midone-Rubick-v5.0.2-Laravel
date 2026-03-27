<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametrizacion\StoreBloqueRequest;
use App\Http\Requests\Parametrizacion\UpdateBloqueRequest;
use App\Models\Bloque;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BloqueController extends Controller
{
    /**
     * Mostrar listado paginado de bloques.
     */
    public function index(Request $request): View
    {
        $bloques = Bloque::activos()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%')
                      ->orWhere('codigo', 'like', '%' . $request->buscar . '%');
            })
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('parametrizacion.bloques.index', compact('bloques'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create(): View
    {
        return view('parametrizacion.bloques.create');
    }

    /**
     * Almacenar un nuevo bloque.
     */
    public function store(StoreBloqueRequest $request): RedirectResponse
    {
        try {
            Bloque::create($request->validated());

            return redirect()
                ->route('parametrizacion.bloques.index')
                ->with('success', 'Bloque creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el bloque: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de un bloque.
     */
    public function show(Bloque $bloque): View
    {
        return view('parametrizacion.bloques.show', compact('bloque'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Bloque $bloque): View
    {
        return view('parametrizacion.bloques.edit', compact('bloque'));
    }

    /**
     * Actualizar un bloque existente.
     */
    public function update(UpdateBloqueRequest $request, Bloque $bloque): RedirectResponse
    {
        try {
            $bloque->update($request->validated());

            return redirect()
                ->route('parametrizacion.bloques.index')
                ->with('success', 'Bloque actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el bloque: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar (soft delete) un bloque.
     */
    public function destroy(Bloque $bloque): RedirectResponse
    {
        try {
            $bloque->delete();

            return redirect()
                ->route('parametrizacion.bloques.index')
                ->with('success', 'Bloque eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el bloque: ' . $e->getMessage());
        }
    }
}
