@extends('../layouts/' . $layout)

@section('subhead')
    <title>Editar Inmueble - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Editar Inmueble: {{ $inmueble->codigo }}</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('gestion.inmuebles.index') }}" class="hover:text-primary">Inmuebles</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>Editar</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                <form action="{{ route('gestion.inmuebles.update', $inmueble) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="codigo">Código <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('codigo') border-danger @enderror" id="codigo" name="codigo" type="text" value="{{ old('codigo', $inmueble->codigo) }}" required />
                            @error('codigo') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-8">
                            <x-base.form-label for="nombre">Nombre <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('nombre') border-danger @enderror" id="nombre" name="nombre" type="text" value="{{ old('nombre', $inmueble->nombre) }}" required />
                            @error('nombre') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="bloque_id">Bloque</x-base.form-label>
                            <x-base.form-select class="w-full" id="bloque_id" name="bloque_id">
                                <option value="">Seleccionar...</option>
                                @foreach($bloques as $bloque)
                                    <option value="{{ $bloque->id }}" {{ old('bloque_id', $inmueble->bloque_id) == $bloque->id ? 'selected' : '' }}>{{ $bloque->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="tipo_inmueble_id">Tipo de Inmueble</x-base.form-label>
                            <x-base.form-select class="w-full" id="tipo_inmueble_id" name="tipo_inmueble_id">
                                <option value="">Seleccionar...</option>
                                @foreach($tiposInmueble as $tipo)
                                    <option value="{{ $tipo->id }}" {{ old('tipo_inmueble_id', $inmueble->tipo_inmueble_id) == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12">
                            <x-base.form-label for="direccion">Dirección</x-base.form-label>
                            <x-base.form-input class="w-full" id="direccion" name="direccion" type="text" value="{{ old('direccion', $inmueble->direccion) }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="area_m2">Área (m²)</x-base.form-label>
                            <x-base.form-input class="w-full" id="area_m2" name="area_m2" type="number" step="0.01" min="0" value="{{ old('area_m2', $inmueble->area_m2) }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="area_construida_m2">Área Construida (m²)</x-base.form-label>
                            <x-base.form-input class="w-full" id="area_construida_m2" name="area_construida_m2" type="number" step="0.01" min="0" value="{{ old('area_construida_m2', $inmueble->area_construida_m2) }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="estado">Estado <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select class="w-full" id="estado" name="estado" required>
                                <option value="operativo" {{ old('estado', $inmueble->estado) == 'operativo' ? 'selected' : '' }}>Operativo</option>
                                <option value="mantenimiento" {{ old('estado', $inmueble->estado) == 'mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                                <option value="fuera_servicio" {{ old('estado', $inmueble->estado) == 'fuera_servicio' ? 'selected' : '' }}>Fuera de Servicio</option>
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="nivel_deterioro_id">Nivel de Deterioro</x-base.form-label>
                            <x-base.form-select class="w-full" id="nivel_deterioro_id" name="nivel_deterioro_id">
                                <option value="">Seleccionar...</option>
                                @foreach($nivelesDeterioro as $nivel)
                                    <option value="{{ $nivel->id }}" {{ old('nivel_deterioro_id', $inmueble->nivel_deterioro_id) == $nivel->id ? 'selected' : '' }}>{{ $nivel->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="fecha_construccion">Fecha de Construcción</x-base.form-label>
                            <x-base.form-input class="w-full" id="fecha_construccion" name="fecha_construccion" type="date" value="{{ old('fecha_construccion', $inmueble->fecha_construccion?->format('Y-m-d')) }}" />
                        </div>
                        {{-- <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="valor_catastral">Valor Catastral ($)</x-base.form-label>
                            <x-base.form-input class="w-full" id="valor_catastral" name="valor_catastral" type="number" step="0.01" min="0" value="{{ old('valor_catastral', $inmueble->valor_catastral) }}" />
                        </div> --}}
                        <div class="col-span-12">
                            <x-base.form-label>Ubicación en Mapa</x-base.form-label>
                            @include('components.map-selector', ['latitud' => old('latitud', $inmueble->latitud ?? 76.385429), 'longitud' => old('longitud', $inmueble->longitud ?? 3.556940)])
                        </div>
                        <div class="col-span-12">
                            <x-base.form-label for="observaciones">Observaciones</x-base.form-label>
                            <x-base.form-textarea class="w-full" id="observaciones" name="observaciones" rows="3">{{ old('observaciones', $inmueble->observaciones) }}</x-base.form-textarea>
                        </div>
                        <div class="col-span-12">
                            <x-base.form-switch class="mt-2">
                                <x-base.form-switch.input type="checkbox" name="activo" value="1" {{ old('activo', $inmueble->activo) ? 'checked' : '' }} />
                                <x-base.form-switch.label>Activo</x-base.form-switch.label>
                            </x-base.form-switch>
                        </div>
                    </div>
                    <div class="mt-5 text-right">
                        <a href="{{ route('gestion.inmuebles.index') }}">
                            <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button>
                        </a>
                        <x-base.button class="w-24" type="submit" variant="primary">Actualizar</x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
