@extends('../layouts/' . $layout)

@section('subhead')
    <title>Editar Categoría de Equipo - Parametrización ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Editar Categoría: {{ $categoria->nombre }}</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('parametrizacion.categorias_equipo.index') }}" class="hover:text-primary">Categorías de Equipo</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" /><span>Editar</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <form action="{{ route('parametrizacion.categorias_equipo.update', $categoria) }}" method="POST">
                    @csrf @method('PUT')
                    <div>
                        <x-base.form-label for="nombre">Nombre <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input class="w-full @error('nombre') border-danger @enderror" id="nombre" name="nombre" type="text" value="{{ old('nombre', $categoria->nombre) }}" required />
                        @error('nombre') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="tipo_equipo_id">Tipo de Equipo</x-base.form-label>
                        <x-base.form-select class="w-full @error('tipo_equipo_id') border-danger @enderror" id="tipo_equipo_id" name="tipo_equipo_id">
                            <option value="">-- Seleccione un tipo --</option>
                            @foreach ($tiposEquipo as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_equipo_id', $categoria->tipo_equipo_id) == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                            @endforeach
                        </x-base.form-select>
                        @error('tipo_equipo_id') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="descripcion">Descripción</x-base.form-label>
                        <x-base.form-textarea class="w-full @error('descripcion') border-danger @enderror" id="descripcion" name="descripcion">{{ old('descripcion', $categoria->descripcion) }}</x-base.form-textarea>
                        @error('descripcion') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <label>Estado</label>
                        <x-base.form-switch class="mt-2">
                            <x-base.form-switch.input type="checkbox" name="activo" value="1" {{ old('activo', $categoria->activo) ? 'checked' : '' }} />
                            <x-base.form-switch.label>Activo</x-base.form-switch.label>
                        </x-base.form-switch>
                    </div>
                    <div class="mt-5 text-right">
                        <a href="{{ route('parametrizacion.categorias_equipo.index') }}"><x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button></a>
                        <x-base.button class="w-24" type="submit" variant="primary">Actualizar</x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
