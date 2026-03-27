@extends('../layouts/' . $layout)

@section('subhead')
    <title>Editar Bloque - Parametrización ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Editar Bloque: {{ $bloque->nombre }}</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('parametrizacion.bloques.index') }}" class="hover:text-primary">Bloques</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>Editar</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <form action="{{ route('parametrizacion.bloques.update', $bloque) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-base.form-label for="nombre">Nombre <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input class="w-full @error('nombre') border-danger @enderror" id="nombre" name="nombre" type="text" value="{{ old('nombre', $bloque->nombre) }}" placeholder="Nombre del bloque" required />
                        @error('nombre') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="codigo">Código <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input class="w-full @error('codigo') border-danger @enderror" id="codigo" name="codigo" type="text" value="{{ old('codigo', $bloque->codigo) }}" placeholder="Código único" required />
                        @error('codigo') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="area_m2">Área (m²)</x-base.form-label>
                        <x-base.form-input class="w-full @error('area_m2') border-danger @enderror" id="area_m2" name="area_m2" type="number" step="0.01" min="0" value="{{ old('area_m2', $bloque->area_m2) }}" placeholder="0.00" />
                        @error('area_m2') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="descripcion">Descripción</x-base.form-label>
                        <x-base.form-textarea class="w-full @error('descripcion') border-danger @enderror" id="descripcion" name="descripcion" placeholder="Descripción del bloque">{{ old('descripcion', $bloque->descripcion) }}</x-base.form-textarea>
                        @error('descripcion') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <label>Estado</label>
                        <x-base.form-switch class="mt-2">
                            <x-base.form-switch.input type="checkbox" name="activo" value="1" {{ old('activo', $bloque->activo) ? 'checked' : '' }} />
                            <x-base.form-switch.label>Activo</x-base.form-switch.label>
                        </x-base.form-switch>
                    </div>
                    <div class="mt-5 text-right">
                        <a href="{{ route('parametrizacion.bloques.index') }}">
                            <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button>
                        </a>
                        <x-base.button class="w-24" type="submit" variant="primary">Actualizar</x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
