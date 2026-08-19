@extends('../layouts/' . $layout)

@section('subhead')
    <title>Crear Tipo de Equipo - Parametrización ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Nuevo Tipo de Equipo</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('parametrizacion.tipos_equipo.index') }}" class="hover:text-primary">Tipos de Equipo</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" /><span>Crear</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <form action="{{ route('parametrizacion.tipos_equipo.store') }}" method="POST">
                    @csrf
                    <div>
                        <x-base.form-label for="nombre">Nombre <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input class="w-full @error('nombre') border-danger @enderror" id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" placeholder="Ej: Transformador de potencia" required />
                        @error('nombre') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="categoria_equipo_id">Categoría</x-base.form-label>
                        <x-base.form-select class="w-full @error('categoria_equipo_id') border-danger @enderror" id="categoria_equipo_id" name="categoria_equipo_id">
                            <option value="">-- Seleccione una categoría --</option>
                            @foreach($categoriasEquipo as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoria_equipo_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                            @endforeach
                        </x-base.form-select>
                        @error('categoria_equipo_id') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="descripcion">Descripción</x-base.form-label>
                        <x-base.form-textarea class="w-full @error('descripcion') border-danger @enderror" id="descripcion" name="descripcion" placeholder="Descripción del tipo">{{ old('descripcion') }}</x-base.form-textarea>
                        @error('descripcion') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <label>Estado</label>
                        <x-base.form-switch class="mt-2">
                            <x-base.form-switch.input type="checkbox" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }} />
                            <x-base.form-switch.label>Activo</x-base.form-switch.label>
                        </x-base.form-switch>
                    </div>
                    <div class="mt-5 text-right">
                        <a href="{{ route('parametrizacion.tipos_equipo.index') }}"><x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button></a>
                        <x-base.button class="w-24" type="submit" variant="primary">Guardar</x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection