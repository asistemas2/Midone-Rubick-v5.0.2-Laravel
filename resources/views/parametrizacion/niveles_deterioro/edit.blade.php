@extends('../layouts/' . $layout)

@section('subhead')
    <title>Editar Nivel de Deterioro - Parametrización ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Editar Nivel: {{ $nivel->nombre }}</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('parametrizacion.niveles_deterioro.index') }}" class="hover:text-primary">Niveles de Deterioro</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" /><span>Editar</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <form action="{{ route('parametrizacion.niveles_deterioro.update', $nivel) }}" method="POST">
                    @csrf @method('PUT')
                    <div>
                        <x-base.form-label for="nombre">Nombre <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input class="w-full @error('nombre') border-danger @enderror" id="nombre" name="nombre" type="text" value="{{ old('nombre', $nivel->nombre) }}" required />
                        @error('nombre') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="codigo">Código <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input class="w-full @error('codigo') border-danger @enderror" id="codigo" name="codigo" type="text" value="{{ old('codigo', $nivel->codigo) }}" required />
                        @error('codigo') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="color_hex">Color</x-base.form-label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="color_hex" name="color_hex" value="{{ old('color_hex', $nivel->color_hex) }}" class="h-10 w-14 cursor-pointer rounded border border-slate-200 p-1" />
                            <span id="color_hex_label" class="text-sm text-slate-500">{{ old('color_hex', $nivel->color_hex) }}</span>
                        </div>
                        @error('color_hex') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="orden">Orden</x-base.form-label>
                        <x-base.form-input class="w-full @error('orden') border-danger @enderror" id="orden" name="orden" type="number" min="0" max="255" value="{{ old('orden', $nivel->orden) }}" />
                        @error('orden') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <label>Estado</label>
                        <x-base.form-switch class="mt-2">
                            <x-base.form-switch.input type="checkbox" name="activo" value="1" {{ old('activo', $nivel->activo) ? 'checked' : '' }} />
                            <x-base.form-switch.label>Activo</x-base.form-switch.label>
                        </x-base.form-switch>
                    </div>
                    <div class="mt-5 text-right">
                        <a href="{{ route('parametrizacion.niveles_deterioro.index') }}"><x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button></a>
                        <x-base.button class="w-24" type="submit" variant="primary">Actualizar</x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('color_hex').addEventListener('input', function() {
            document.getElementById('color_hex_label').textContent = this.value;
        });
    </script>
@endsection
