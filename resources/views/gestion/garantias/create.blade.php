@extends('../layouts/' . $layout)

@section('subhead')
    <title>Crear Garantía - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Nueva Garantía</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('gestion.garantias.index') }}" class="hover:text-primary">Garantías</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>Crear</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                <form action="{{ route('gestion.garantias.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="codigo">Código <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('codigo') border-danger @enderror" id="codigo" name="codigo" type="text" value="{{ old('codigo') }}" placeholder="GAR-001" required />
                            @error('codigo') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="mantenimiento_id">Mantenimiento</x-base.form-label>
                            <x-base.form-select class="w-full" id="mantenimiento_id" name="mantenimiento_id">
                                <option value="">Seleccionar...</option>
                                @foreach($mantenimientos as $mant)
                                    <option value="{{ $mant->id }}" {{ old('mantenimiento_id') == $mant->id ? 'selected' : '' }}>[{{ $mant->codigo }}] {{ Str::limit($mant->descripcion, 40) }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="tipo_activo">Tipo de Activo <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select class="w-full" id="tipo_activo" name="tipo_activo" required>
                                <option value="">Seleccionar...</option>
                                <option value="inmueble" {{ old('tipo_activo') == 'inmueble' ? 'selected' : '' }}>Inmueble</option>
                                <option value="equipo" {{ old('tipo_activo') == 'equipo' ? 'selected' : '' }}>Equipo</option>
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="estado">Estado <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select class="w-full" id="estado" name="estado" required>
                                <option value="activa" {{ old('estado', 'activa') == 'activa' ? 'selected' : '' }}>Activa</option>
                                <option value="vencida" {{ old('estado') == 'vencida' ? 'selected' : '' }}>Vencida</option>
                                <option value="en_tramite" {{ old('estado') == 'en_tramite' ? 'selected' : '' }}>En Trámite</option>
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="fecha_inicio">Fecha Inicio</x-base.form-label>
                            <x-base.form-input class="w-full" id="fecha_inicio" name="fecha_inicio" type="date" value="{{ old('fecha_inicio') }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="fecha_fin">Fecha Fin</x-base.form-label>
                            <x-base.form-input class="w-full" id="fecha_fin" name="fecha_fin" type="date" value="{{ old('fecha_fin') }}" />
                            @error('fecha_fin') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="proveedor">Proveedor</x-base.form-label>
                            <x-base.form-input class="w-full" id="proveedor" name="proveedor" type="text" value="{{ old('proveedor') }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="monto">Monto ($)</x-base.form-label>
                            <x-base.form-input class="w-full" id="monto" name="monto" type="number" step="0.01" min="0" value="{{ old('monto') }}" placeholder="0.00" />
                        </div>
                        <div class="col-span-12">
                            <x-base.form-label for="terminos">Términos</x-base.form-label>
                            <x-base.form-textarea class="w-full" id="terminos" name="terminos" rows="3">{{ old('terminos') }}</x-base.form-textarea>
                        </div>
                        <div class="col-span-12">
                            <x-base.form-label for="observaciones">Observaciones</x-base.form-label>
                            <x-base.form-textarea class="w-full" id="observaciones" name="observaciones" rows="3">{{ old('observaciones') }}</x-base.form-textarea>
                        </div>
                        <div class="col-span-12">
                            <x-base.form-switch class="mt-2">
                                <x-base.form-switch.input type="checkbox" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }} />
                                <x-base.form-switch.label>Activo</x-base.form-switch.label>
                            </x-base.form-switch>
                        </div>
                    </div>
                    <div class="mt-5 text-right">
                        <a href="{{ route('gestion.garantias.index') }}">
                            <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button>
                        </a>
                        <x-base.button class="w-24" type="submit" variant="primary">Guardar</x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
