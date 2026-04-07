@extends('../layouts/' . $layout)

@section('subhead')
    <title>Crear Equipo - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Nuevo Equipo</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('gestion.equipos.index') }}" class="hover:text-primary">Equipos</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>Crear</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                <form action="{{ route('gestion.equipos.store') }}" method="POST">
                    @csrf
                    {{-- Información Básica --}}
                    <div class="border-b border-slate-200/60 pb-4 mb-4">
                        <h3 class="text-base font-medium">Información Básica</h3>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="codigo">Código <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('codigo') border-danger @enderror" id="codigo" name="codigo" type="text" value="{{ old('codigo') }}" placeholder="EQ-001" required />
                            @error('codigo') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-8">
                            <x-base.form-label for="nombre">Nombre <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('nombre') border-danger @enderror" id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" required />
                            @error('nombre') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="tipo_equipo_id">Tipo Equipo</x-base.form-label>
                            <x-base.form-select class="w-full" id="tipo_equipo_id" name="tipo_equipo_id" onchange="cargarCategorias(this.value)">
                                <option value="">Seleccionar...</option>
                                @foreach($tiposEquipo as $tipo)
                                    <option value="{{ $tipo->id }}" {{ old('tipo_equipo_id') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="categoria_equipo_id">Categoría</x-base.form-label>
                            <x-base.form-select class="w-full" id="categoria_equipo_id" name="categoria_equipo_id">
                                <option value="">Seleccionar...</option>
                                @foreach($categoriasEquipo as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categoria_equipo_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="marca_id">Marca</x-base.form-label>
                            <x-base.form-select class="w-full" id="marca_id" name="marca_id">
                                <option value="">Seleccionar...</option>
                                @foreach($marcas as $marca)
                                    <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>{{ $marca->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="modelo">Modelo</x-base.form-label>
                            <x-base.form-input class="w-full" id="modelo" name="modelo" type="text" value="{{ old('modelo') }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="no_serie">No. Serie</x-base.form-label>
                            <x-base.form-input class="w-full" id="no_serie" name="no_serie" type="text" value="{{ old('no_serie') }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="inmueble_id">Inmueble</x-base.form-label>
                            <x-base.form-select class="w-full" id="inmueble_id" name="inmueble_id">
                                <option value="">Seleccionar...</option>
                                @foreach($inmuebles as $inmueble)
                                    <option value="{{ $inmueble->id }}" {{ old('inmueble_id') == $inmueble->id ? 'selected' : '' }}>{{ $inmueble->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                    </div>

                    {{-- Especificaciones Técnicas --}}
                    <div class="border-b border-slate-200/60 pb-4 mb-4 mt-6">
                        <h3 class="text-base font-medium">Especificaciones Técnicas</h3>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="ubicacion_especifica">Ubicación Específica</x-base.form-label>
                            <x-base.form-input class="w-full" id="ubicacion_especifica" name="ubicacion_especifica" type="text" value="{{ old('ubicacion_especifica') }}" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <x-base.form-label for="capacidad">Capacidad</x-base.form-label>
                            <x-base.form-input class="w-full" id="capacidad" name="capacidad" type="text" value="{{ old('capacidad') }}" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <x-base.form-label for="voltaje">Voltaje</x-base.form-label>
                            <x-base.form-input class="w-full" id="voltaje" name="voltaje" type="text" value="{{ old('voltaje') }}" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <x-base.form-label for="potencia">Potencia</x-base.form-label>
                            <x-base.form-input class="w-full" id="potencia" name="potencia" type="text" value="{{ old('potencia') }}" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <x-base.form-label for="frecuencia">Frecuencia</x-base.form-label>
                            <x-base.form-input class="w-full" id="frecuencia" name="frecuencia" type="text" value="{{ old('frecuencia') }}" />
                        </div>
                        <div class="col-span-12">
                            <x-base.form-label for="descripcion">Descripción</x-base.form-label>
                            <x-base.form-textarea class="w-full" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</x-base.form-textarea>
                        </div>
                    </div>

                    {{-- Estado y Mantenimiento --}}
                    <div class="border-b border-slate-200/60 pb-4 mb-4 mt-6">
                        <h3 class="text-base font-medium">Estado y Mantenimiento</h3>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="estado_equipo_id">Estado</x-base.form-label>
                            <x-base.form-select class="w-full" id="estado_equipo_id" name="estado_equipo_id">
                                <option value="">Seleccionar...</option>
                                @foreach($estadosEquipo as $estado)
                                    <option value="{{ $estado->id }}" {{ old('estado_equipo_id') == $estado->id ? 'selected' : '' }}>{{ $estado->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="criticidad_id">Criticidad</x-base.form-label>
                            <x-base.form-select class="w-full" id="criticidad_id" name="criticidad_id">
                                <option value="">Seleccionar...</option>
                                @foreach($criticidades as $crit)
                                    <option value="{{ $crit->id }}" {{ old('criticidad_id') == $crit->id ? 'selected' : '' }}>{{ $crit->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="periodicidad_mantenimiento_id">Periodicidad Mantenimiento</x-base.form-label>
                            <x-base.form-select class="w-full" id="periodicidad_mantenimiento_id" name="periodicidad_mantenimiento_id">
                                <option value="">Seleccionar...</option>
                                @foreach($periodicidades as $per)
                                    <option value="{{ $per->id }}" {{ old('periodicidad_mantenimiento_id') == $per->id ? 'selected' : '' }}>{{ $per->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <x-base.form-label for="fecha_adquisicion">Fecha Adquisición</x-base.form-label>
                            <x-base.form-input class="w-full" id="fecha_adquisicion" name="fecha_adquisicion" type="date" value="{{ old('fecha_adquisicion') }}" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <x-base.form-label for="fecha_instalacion">Fecha Instalación</x-base.form-label>
                            <x-base.form-input class="w-full" id="fecha_instalacion" name="fecha_instalacion" type="date" value="{{ old('fecha_instalacion') }}" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <x-base.form-label for="vida_util_anios">Vida Útil (años)</x-base.form-label>
                            <x-base.form-input class="w-full" id="vida_util_anios" name="vida_util_anios" type="number" min="0" value="{{ old('vida_util_anios') }}" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <x-base.form-label for="garantia_meses">Garantía (meses)</x-base.form-label>
                            <x-base.form-input class="w-full" id="garantia_meses" name="garantia_meses" type="number" min="0" value="{{ old('garantia_meses') }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="proveedor">Proveedor</x-base.form-label>
                            <x-base.form-input class="w-full" id="proveedor" name="proveedor" type="text" value="{{ old('proveedor') }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="responsable">Responsable</x-base.form-label>
                            <x-base.form-input class="w-full" id="responsable" name="responsable" type="text" value="{{ old('responsable') }}" />
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
                        <a href="{{ route('gestion.equipos.index') }}">
                            <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button>
                        </a>
                        <x-base.button class="w-24" type="submit" variant="primary">Guardar</x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function cargarCategorias(tipoId) {
            if (!tipoId) return;
            fetch('{{ route("gestion.equipos.categorias-por-tipo") }}?tipo_equipo_id=' + tipoId)
                .then(r => r.json())
                .then(data => {
                    let select = document.getElementById('categoria_equipo_id');
                    select.innerHTML = '<option value="">Seleccionar...</option>';
                    data.forEach(cat => {
                        select.innerHTML += `<option value="${cat.id}">${cat.nombre}</option>`;
                    });
                });
        }
    </script>
    @endpush
@endsection
