@extends('../layouts/' . $layout)

@section('subhead')
    <title>Crear Estado de Equipo - Parametrización ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Nuevo Estado de Equipo</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('parametrizacion.estados_equipo.index') }}" class="hover:text-primary">Estados de Equipo</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" /><span>Crear</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <form action="{{ route('parametrizacion.estados_equipo.store') }}" method="POST">
                    @csrf
                    <div>
                        <x-base.form-label for="nombre">Nombre <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input class="w-full @error('nombre') border-danger @enderror" id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" placeholder="Ej: Operativo, En Mantenimiento" required />
                        @error('nombre') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="codigo">Código <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input class="w-full @error('codigo') border-danger @enderror" id="codigo" name="codigo" type="text" value="{{ old('codigo') }}" placeholder="Código único" required />
                        @error('codigo') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="color_hex">Color</x-base.form-label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="color_hex" name="color_hex" value="{{ old('color_hex', '#6c757d') }}" class="h-10 w-14 cursor-pointer rounded border border-slate-200 p-1" />
                            <span id="color_hex_label" class="text-sm text-slate-500">{{ old('color_hex', '#6c757d') }}</span>
                        </div>
                        @error('color_hex') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <label>Estado</label>
                        <x-base.form-switch class="mt-2">
                            <x-base.form-switch.input type="checkbox" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }} />
                            <x-base.form-switch.label>Activo</x-base.form-switch.label>
                        </x-base.form-switch>
                    </div>
                    <div class="mt-5 text-right">
                        <a href="{{ route('parametrizacion.estados_equipo.index') }}"><x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button></a>
                        <x-base.button class="w-24" type="submit" variant="primary">Guardar</x-base.button>
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
