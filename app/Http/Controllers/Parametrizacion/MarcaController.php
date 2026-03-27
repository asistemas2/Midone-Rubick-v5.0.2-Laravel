<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametrizacion\StoreMarcaRequest;
use App\Http\Requests\Parametrizacion\UpdateMarcaRequest;
use App\Models\Marca;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarcaController extends Controller
{
    /**
     * Mostrar listado paginado de marcas.
     */
    public function index(Request $request): View
    {
        $marcas = Marca::activos()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%')
                      ->orWhere('pais_origen', 'like', '%' . $request->buscar . '%');
            })
            ->ordenadas()
            ->paginate(15)
            ->withQueryString();

        return view('parametrizacion.marcas.index', compact('marcas'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create(): View
    {
        return view('parametrizacion.marcas.create');
    }

    /**
     * Almacenar una nueva marca.
     */
    public function store(StoreMarcaRequest $request): RedirectResponse
    {
        try {
            Marca::create($request->validated());

            return redirect()
                ->route('parametrizacion.marcas.index')
                ->with('success', 'Marca creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear la marca: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de una marca.
     */
    public function show(Marca $marca): View
    {
        return view('parametrizacion.marcas.show', compact('marca'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Marca $marca): View
    {
        return view('parametrizacion.marcas.edit', compact('marca'));
    }

    /**
     * Actualizar una marca existente.
     */
    public function update(UpdateMarcaRequest $request, Marca $marca): RedirectResponse
    {
        try {
            $marca->update($request->validated());

            return redirect()
                ->route('parametrizacion.marcas.index')
                ->with('success', 'Marca actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar la marca: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar (soft delete) una marca.
     */
    public function destroy(Marca $marca): RedirectResponse
    {
        try {
            $marca->delete();

            return redirect()
                ->route('parametrizacion.marcas.index')
                ->with('success', 'Marca eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar la marca: ' . $e->getMessage());
        }
    }
}
