<?php

namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametrizacion\StorePeriodicidadMantenimientoRequest;
use App\Http\Requests\Parametrizacion\UpdatePeriodicidadMantenimientoRequest;
use App\Models\PeriodicidadMantenimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeriodicidadMantenimientoController extends Controller
{
    /**
     * Mostrar listado paginado de periodicidades de mantenimiento.
     */
    public function index(Request $request): View
    {
        $periodicidades = PeriodicidadMantenimiento::activos()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%');
            })
            ->ordenadas()
            ->paginate(15)
            ->withQueryString();

        return view('parametrizacion.periodicidades_mantenimiento.index', compact('periodicidades'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create(): View
    {
        return view('parametrizacion.periodicidades_mantenimiento.create');
    }

    /**
     * Almacenar una nueva periodicidad.
     */
    public function store(StorePeriodicidadMantenimientoRequest $request): RedirectResponse
    {
        try {
            PeriodicidadMantenimiento::create($request->validated());

            return redirect()
                ->route('parametrizacion.periodicidades_mantenimiento.index')
                ->with('success', 'Periodicidad de mantenimiento creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear la periodicidad: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalle de una periodicidad.
     */
    public function show(PeriodicidadMantenimiento $periodicidades_mantenimiento): View
    {
        return view('parametrizacion.periodicidades_mantenimiento.show', [
            'periodicidad' => $periodicidades_mantenimiento,
        ]);
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(PeriodicidadMantenimiento $periodicidades_mantenimiento): View
    {
        return view('parametrizacion.periodicidades_mantenimiento.edit', [
            'periodicidad' => $periodicidades_mantenimiento,
        ]);
    }

    /**
     * Actualizar una periodicidad existente.
     */
    public function update(UpdatePeriodicidadMantenimientoRequest $request, PeriodicidadMantenimiento $periodicidades_mantenimiento): RedirectResponse
    {
        try {
            $periodicidades_mantenimiento->update($request->validated());

            return redirect()
                ->route('parametrizacion.periodicidades_mantenimiento.index')
                ->with('success', 'Periodicidad de mantenimiento actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar la periodicidad: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar (soft delete) una periodicidad.
     */
    public function destroy(PeriodicidadMantenimiento $periodicidades_mantenimiento): RedirectResponse
    {
        try {
            $periodicidades_mantenimiento->delete();

            return redirect()
                ->route('parametrizacion.periodicidades_mantenimiento.index')
                ->with('success', 'Periodicidad de mantenimiento eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar la periodicidad: ' . $e->getMessage());
        }
    }
}
