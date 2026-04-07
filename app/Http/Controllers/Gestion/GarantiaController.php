<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gestion\StoreGarantiaRequest;
use App\Http\Requests\Gestion\UpdateGarantiaRequest;
use App\Models\Garantia;
use App\Models\Mantenimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GarantiaController extends Controller
{
    public function index(Request $request): View
    {
        $garantias = Garantia::activos()
            ->with(['mantenimiento'])
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('codigo', 'like', '%' . $request->buscar . '%')
                      ->orWhere('proveedor', 'like', '%' . $request->buscar . '%');
            })
            ->when($request->filled('estado'), function ($query) use ($request) {
                $query->where('estado', $request->estado);
            })
            ->when($request->filled('vigencia'), function ($query) use ($request) {
                if ($request->vigencia === 'vigente') {
                    $query->where('estado', 'activa')->where('fecha_fin', '>=', now());
                } elseif ($request->vigencia === 'por_vencer') {
                    $query->where('estado', 'activa')
                          ->where('fecha_fin', '>=', now())
                          ->where('fecha_fin', '<=', now()->addDays(30));
                }
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('gestion.garantias.index', compact('garantias'));
    }

    public function create(): View
    {
        $mantenimientos = Mantenimiento::activos()->orderByDesc('fecha_programada')->get();

        return view('gestion.garantias.create', compact('mantenimientos'));
    }

    public function store(StoreGarantiaRequest $request): RedirectResponse
    {
        try {
            Garantia::create($request->validated());

            return redirect()
                ->route('gestion.garantias.index')
                ->with('success', 'Garantía creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear la garantía: ' . $e->getMessage());
        }
    }

    public function show(Garantia $garantia): View
    {
        $garantia->load(['mantenimiento']);

        return view('gestion.garantias.show', compact('garantia'));
    }

    public function edit(Garantia $garantia): View
    {
        $mantenimientos = Mantenimiento::activos()->orderByDesc('fecha_programada')->get();

        return view('gestion.garantias.edit', compact('garantia', 'mantenimientos'));
    }

    public function update(UpdateGarantiaRequest $request, Garantia $garantia): RedirectResponse
    {
        try {
            $garantia->update($request->validated());

            return redirect()
                ->route('gestion.garantias.index')
                ->with('success', 'Garantía actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar la garantía: ' . $e->getMessage());
        }
    }

    public function destroy(Garantia $garantia): RedirectResponse
    {
        try {
            $garantia->delete();

            return redirect()
                ->route('gestion.garantias.index')
                ->with('success', 'Garantía eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar la garantía: ' . $e->getMessage());
        }
    }
}
