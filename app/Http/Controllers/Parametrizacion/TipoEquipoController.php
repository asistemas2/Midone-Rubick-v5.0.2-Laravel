<?php
namespace App\Http\Controllers\Parametrizacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametrizacion\StoreTipoEquipoRequest;
use App\Http\Requests\Parametrizacion\UpdateTipoEquipoRequest;
use App\Models\TipoEquipo;
use App\Models\CategoriaEquipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TipoEquipoController extends Controller
{
    public function index(Request $request): View
    {
        $tiposEquipo = TipoEquipo::activos()
            ->with('categoriaEquipo')
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->buscar . '%');
            })
            ->when($request->filled('categoria_equipo_id'), function ($query) use ($request) {
                $query->where('categoria_equipo_id', $request->categoria_equipo_id);
            })
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        $categoriasEquipo = CategoriaEquipo::activos()->orderBy('nombre')->get();

        return view('parametrizacion.tipos_equipo.index', compact('tiposEquipo', 'categoriasEquipo'));
    }

    public function create(): View
    {
        $categoriasEquipo = CategoriaEquipo::activos()->orderBy('nombre')->get();
        return view('parametrizacion.tipos_equipo.create', compact('categoriasEquipo'));
    }

    public function store(StoreTipoEquipoRequest $request): RedirectResponse
    {
        try {
            TipoEquipo::create($request->validated());
            return redirect()->route('parametrizacion.tipos_equipo.index')
                ->with('success', 'Tipo de equipo creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Error al crear el tipo de equipo: ' . $e->getMessage());
        }
    }

    public function show(TipoEquipo $tipos_equipo): View
    {
        $tipos_equipo->load('categoriaEquipo');
        return view('parametrizacion.tipos_equipo.show', ['tipoEquipo' => $tipos_equipo]);
    }

    public function edit(TipoEquipo $tipos_equipo): View
    {
        $categoriasEquipo = CategoriaEquipo::activos()->orderBy('nombre')->get();
        return view('parametrizacion.tipos_equipo.edit', [
            'tipoEquipo' => $tipos_equipo,
            'categoriasEquipo' => $categoriasEquipo,
        ]);
    }

    public function update(UpdateTipoEquipoRequest $request, TipoEquipo $tipos_equipo): RedirectResponse
    {
        try {
            $tipos_equipo->update($request->validated());
            return redirect()->route('parametrizacion.tipos_equipo.index')
                ->with('success', 'Tipo de equipo actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Error al actualizar el tipo de equipo: ' . $e->getMessage());
        }
    }

    public function destroy(TipoEquipo $tipos_equipo): RedirectResponse
    {
        try {
            $tipos_equipo->delete();
            return redirect()->route('parametrizacion.tipos_equipo.index')
                ->with('success', 'Tipo de equipo eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el tipo de equipo: ' . $e->getMessage());
        }
    }
}