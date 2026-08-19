<?php
namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametrizacion\StoreCategoriaEquipoRequest;
use App\Http\Requests\Parametrizacion\UpdateCategoriaEquipoRequest;
use App\Models\CategoriaEquipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaEquipoController extends Controller
{
    public function index(Request $request): View
    {
        $categorias = CategoriaEquipo::activos()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%');
            })
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('parametrizacion.categorias_equipo.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('parametrizacion.categorias_equipo.create');
    }

    public function store(StoreCategoriaEquipoRequest $request): RedirectResponse
    {
        try {
            CategoriaEquipo::create($request->validated());
            return redirect()->route('parametrizacion.categorias_equipo.index')
                ->with('success', 'Categoría de equipo creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Error al crear la categoría de equipo: ' . $e->getMessage());
        }
    }

    public function show(CategoriaEquipo $categorias_equipo): View
    {
        $categorias_equipo->load('tiposEquipo'); // ahora tiene muchos tipos
        return view('parametrizacion.categorias_equipo.show', ['categoria' => $categorias_equipo]);
    }

    public function edit(CategoriaEquipo $categorias_equipo): View
    {
        return view('parametrizacion.categorias_equipo.edit', ['categoria' => $categorias_equipo]);
    }

    public function update(UpdateCategoriaEquipoRequest $request, CategoriaEquipo $categorias_equipo): RedirectResponse
    {
        try {
            $categorias_equipo->update($request->validated());
            return redirect()->route('parametrizacion.categorias_equipo.index')
                ->with('success', 'Categoría de equipo actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Error al actualizar la categoría de equipo: ' . $e->getMessage());
        }
    }

    public function destroy(CategoriaEquipo $categorias_equipo): RedirectResponse
    {
        try {
            $categorias_equipo->delete();
            return redirect()->route('parametrizacion.categorias_equipo.index')
                ->with('success', 'Categoría de equipo eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la categoría de equipo: ' . $e->getMessage());
        }
    }
}