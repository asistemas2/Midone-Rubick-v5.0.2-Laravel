<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametrizacion\StoreTipoInmuebleRequest;
use App\Http\Requests\Parametrizacion\UpdateTipoInmuebleRequest;
use App\Models\TipoInmueble;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TipoInmuebleController extends Controller
{
    /**
     * Mostrar listado paginado de tipos de inmueble.
     */
    public function index(Request $request): View
    {
        $tiposInmueble = TipoInmueble::activos()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%');
            })
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('parametrizacion.tipos_inmueble.index', compact('tiposInmueble'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create(): View
    {
        return view('parametrizacion.tipos_inmueble.create');
    }

    /**
     * Almacenar un nuevo tipo de inmueble.
     */
    public function store(StoreTipoInmuebleRequest $request): RedirectResponse
    {
        try {
            TipoInmueble::create($request->validated());

            return redirect()
                ->route('parametrizacion.tipos_inmueble.index')
                ->with('success', 'Tipo de inmueble creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el tipo de inmueble: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de un tipo de inmueble.
     */
    public function show(TipoInmueble $tipos_inmueble): View
    {
        return view('parametrizacion.tipos_inmueble.show', ['tipoInmueble' => $tipos_inmueble]);
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(TipoInmueble $tipos_inmueble): View
    {
        return view('parametrizacion.tipos_inmueble.edit', ['tipoInmueble' => $tipos_inmueble]);
    }

    /**
     * Actualizar un tipo de inmueble existente.
     */
    public function update(UpdateTipoInmuebleRequest $request, TipoInmueble $tipos_inmueble): RedirectResponse
    {
        try {
            $tipos_inmueble->update($request->validated());

            return redirect()
                ->route('parametrizacion.tipos_inmueble.index')
                ->with('success', 'Tipo de inmueble actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el tipo de inmueble: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar (soft delete) un tipo de inmueble.
     */
    public function destroy(TipoInmueble $tipos_inmueble): RedirectResponse
    {
        try {
            $tipos_inmueble->delete();

            return redirect()
                ->route('parametrizacion.tipos_inmueble.index')
                ->with('success', 'Tipo de inmueble eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el tipo de inmueble: ' . $e->getMessage());
        }
    }
}
