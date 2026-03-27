<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametrizacion\StoreNivelDeterioroRequest;
use App\Http\Requests\Parametrizacion\UpdateNivelDeterioroRequest;
use App\Models\NivelDeterioro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NivelDeterioroController extends Controller
{
    /**
     * Mostrar listado paginado de niveles de deterioro.
     */
    public function index(Request $request): View
    {
        $niveles = NivelDeterioro::activos()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%')
                      ->orWhere('codigo', 'like', '%' . $request->buscar . '%');
            })
            ->ordenados()
            ->paginate(15)
            ->withQueryString();

        return view('parametrizacion.niveles_deterioro.index', compact('niveles'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create(): View
    {
        return view('parametrizacion.niveles_deterioro.create');
    }

    /**
     * Almacenar un nuevo nivel de deterioro.
     */
    public function store(StoreNivelDeterioroRequest $request): RedirectResponse
    {
        try {
            NivelDeterioro::create($request->validated());

            return redirect()
                ->route('parametrizacion.niveles_deterioro.index')
                ->with('success', 'Nivel de deterioro creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el nivel de deterioro: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de un nivel de deterioro.
     */
    public function show(NivelDeterioro $niveles_deterioro): View
    {
        return view('parametrizacion.niveles_deterioro.show', ['nivel' => $niveles_deterioro]);
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(NivelDeterioro $niveles_deterioro): View
    {
        return view('parametrizacion.niveles_deterioro.edit', ['nivel' => $niveles_deterioro]);
    }

    /**
     * Actualizar un nivel de deterioro existente.
     */
    public function update(UpdateNivelDeterioroRequest $request, NivelDeterioro $niveles_deterioro): RedirectResponse
    {
        try {
            $niveles_deterioro->update($request->validated());

            return redirect()
                ->route('parametrizacion.niveles_deterioro.index')
                ->with('success', 'Nivel de deterioro actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el nivel de deterioro: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar (soft delete) un nivel de deterioro.
     */
    public function destroy(NivelDeterioro $niveles_deterioro): RedirectResponse
    {
        try {
            $niveles_deterioro->delete();

            return redirect()
                ->route('parametrizacion.niveles_deterioro.index')
                ->with('success', 'Nivel de deterioro eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el nivel de deterioro: ' . $e->getMessage());
        }
    }
}
