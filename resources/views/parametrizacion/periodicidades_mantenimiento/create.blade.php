@extends('../layouts/' . $layout)

@section('subhead')
    <title>Crear Periodicidad - Parametrización ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Nueva Periodicidad de Mantenimiento</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('parametrizacion.periodicidades_mantenimiento.index') }}" class="hover:text-primary">Periodicidades</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" /><span>Crear</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <form action="{{ route('parametrizacion.periodicidades_mantenimiento.store') }}" method="POST">
                    @csrf
                    <div>
                        <x-base.form-label for="nombre">Nombre <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input class="w-full {{ $errors->has('nombre') ? 'border-danger' : '' }}" id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" placeholder="Ej: Semanal, Mensual" required />
                        @error('nombre') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="dias_frecuencia">Días de Frecuencia <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input class="w-full {{ $errors->has('dias_frecuencia') ? 'border-danger' : '' }}" id="dias_frecuencia" name="dias_frecuencia" type="number" min="1" max="3650" value="{{ old('dias_frecuencia') }}" placeholder="Número de días" required />
                        @error('dias_frecuencia') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="descripcion">Descripción</x-base.form-label>
                        <x-base.form-textarea class="w-full {{ $errors->has('descripcion') ? 'border-danger' : '' }}" id="descripcion" name="descripcion" placeholder="Descripción">{{ old('descripcion') }}</x-base.form-textarea>
                        @error('descripcion') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <label>Estado</label>
                        <x-base.form-switch class="mt-2">
                            <input type="hidden" name="activo" value="0" />
                            <x-base.form-switch.input type="checkbox" name="activo" value="1" :checked="old('activo', true)" />
                            <x-base.form-switch.label>Activo</x-base.form-switch.label>
                        </x-base.form-switch>
                    </div>
                    <div class="mt-5 text-right">
                        <a href="{{ route('parametrizacion.periodicidades_mantenimiento.index') }}"><x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button></a>
                        <x-base.button class="w-24" type="submit" variant="primary">Guardar</x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
