@extends('../layouts/' . $layout)

@section('subhead')
    <title>Crear Inmueble - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Nuevo Inmueble</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('gestion.inmuebles.index') }}" class="hover:text-primary">Inmuebles</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>Crear</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                <form action="{{ route('gestion.inmuebles.store') }}" method="POST">
                    @csrf
                    {{-- ====== INFORMACIÓN BÁSICA ====== --}}
                    <div class="border-b border-slate-200/60 pb-4 mb-4">
                        <h3 class="text-base font-medium">Información Básica</h3>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        {{-- Código --}}
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="codigo">Código <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('codigo') border-danger @enderror" id="codigo"
                                name="codigo" type="text" value="{{ old('codigo') }}" placeholder="INM-001" required />
                            @error('codigo')
                                <div class="mt-1 text-xs text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Nombre --}}
                        <div class="col-span-12 sm:col-span-8">
                            <x-base.form-label for="nombre">Nombre <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('nombre') border-danger @enderror" id="nombre"
                                name="nombre" type="text" value="{{ old('nombre') }}" placeholder="Nombre del inmueble"
                                required />
                            @error('nombre')
                                <div class="mt-1 text-xs text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Bloque --}}
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="bloque_id">Bloque</x-base.form-label>
                            <x-base.form-select class="w-full" id="bloque_id" name="bloque_id">
                                <option value="">Seleccionar...</option>
                                @foreach ($bloques as $bloque)
                                    <option value="{{ $bloque->id }}"
                                        {{ old('bloque_id') == $bloque->id ? 'selected' : '' }}>{{ $bloque->nombre }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        {{-- Tipo Inmueble --}}
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="tipo_inmueble_id">Tipo de Inmueble</x-base.form-label>
                            <x-base.form-select class="w-full" id="tipo_inmueble_id" name="tipo_inmueble_id" onchange="toggleFichaTecnica(this.value)">
                                <option value="">Seleccionar...</option>
                                @foreach ($tiposInmueble as $tipo)
                                    <option value="{{ $tipo->id }}"
                                        {{ old('tipo_inmueble_id') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        {{-- Dirección --}}
                        <div class="col-span-12">
                            <x-base.form-label for="direccion">Dirección</x-base.form-label>
                            <x-base.form-input class="w-full" id="direccion" name="direccion" type="text"
                                value="{{ old('direccion') }}" placeholder="Dirección del inmueble" />
                        </div>
                        {{-- Áreas --}}
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="area_m2">Área (m²)</x-base.form-label>
                            <x-base.form-input class="w-full" id="area_m2" name="area_m2" type="number" step="0.01"
                                min="0" value="{{ old('area_m2') }}" placeholder="0.00" />
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="area_construida_m2">Área Construida (m²)</x-base.form-label>
                            <x-base.form-input class="w-full" id="area_construida_m2" name="area_construida_m2"
                                type="number" step="0.01" min="0" value="{{ old('area_construida_m2') }}"
                                placeholder="0.00" />
                        </div>
                        {{-- Estado --}}
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="estado">Estado <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select class="w-full" id="estado" name="estado" required>
                                <option value="operativo"
                                    {{ old('estado', 'operativo') == 'operativo' ? 'selected' : '' }}>Operativo</option>
                                <option value="mantenimiento" {{ old('estado') == 'mantenimiento' ? 'selected' : '' }}>En
                                    Mantenimiento</option>
                                <option value="fuera_servicio" {{ old('estado') == 'fuera_servicio' ? 'selected' : '' }}>
                                    Fuera de Servicio</option>
                            </x-base.form-select>
                        </div>
                        {{-- Nivel Deterioro --}}
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="nivel_deterioro_id">Nivel de Deterioro</x-base.form-label>
                            <x-base.form-select class="w-full" id="nivel_deterioro_id" name="nivel_deterioro_id">
                                <option value="">Seleccionar...</option>
                                @foreach ($nivelesDeterioro as $nivel)
                                    <option value="{{ $nivel->id }}"
                                        {{ old('nivel_deterioro_id') == $nivel->id ? 'selected' : '' }}>
                                        {{ $nivel->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        {{-- Fecha construcción --}}
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="fecha_construccion">Fecha de Construcción</x-base.form-label>
                            <x-base.form-input class="w-full" id="fecha_construccion" name="fecha_construccion"
                                type="date" value="{{ old('fecha_construccion') }}" />
                        </div>
                        {{-- Mapa --}}
                        <div class="col-span-12">
                            <x-base.form-label>Ubicación en Mapa</x-base.form-label>
                            @include('components.map-selector', [
                                'latitud' => old('latitud', 3.55846),
                                'longitud' => old('longitud', -76.38627),
                            ])
                        </div>
                        {{-- Observaciones --}}
                        <div class="col-span-12">
                            <x-base.form-label for="observaciones">Observaciones</x-base.form-label>
                            <x-base.form-textarea class="w-full" id="observaciones" name="observaciones" rows="3"
                                placeholder="Observaciones adicionales">{{ old('observaciones') }}</x-base.form-textarea>
                        </div>
                        {{-- Activo --}}
                        <div class="col-span-12">
                            <x-base.form-switch class="mt-2">
                                <x-base.form-switch.input type="checkbox" name="activo" value="1"
                                    {{ old('activo', true) ? 'checked' : '' }} />
                                <x-base.form-switch.label>Activo</x-base.form-switch.label>
                            </x-base.form-switch>
                        </div>
                    </div>

                    {{-- ====== FICHA TÉCNICA (BODEGA) ====== --}}
                    <div id="fichaTecnicaContainer" class="mt-6" style="display: none;">
                        <div class="border-b border-slate-200/60 pb-4 mb-4">
                            <h3 class="text-base font-medium">Ficha Técnica (Bodega)</h3>
                            <p class="text-xs text-slate-500 mt-1">Complete esta sección solo para inmuebles de tipo Bodega</p>
                        </div>

                        {{-- Áreas --}}
                        <div class="grid grid-cols-12 gap-4 mb-4">
                            <div class="col-span-12">
                                <h4 class="text-sm font-semibold text-slate-700">Áreas</h4>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="ficha_tecnica[area_calificada]">Área Calificada (m²)</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[area_calificada]" name="ficha_tecnica[area_calificada]" type="number" step="0.01" min="0" value="{{ old('ficha_tecnica.area_calificada') }}" />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="ficha_tecnica[area_util]">Área Útil (m²)</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[area_util]" name="ficha_tecnica[area_util]" type="number" step="0.01" min="0" value="{{ old('ficha_tecnica.area_util') }}" />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="ficha_tecnica[area_bruta]">Área Bruta (m²)</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[area_bruta]" name="ficha_tecnica[area_bruta]" type="number" step="0.01" min="0" value="{{ old('ficha_tecnica.area_bruta') }}" />
                            </div>
                        </div>

                        {{-- Servicios --}}
                        <div class="grid grid-cols-12 gap-4 mb-4">
                            <div class="col-span-12">
                                <h4 class="text-sm font-semibold text-slate-700">Servicios</h4>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="ficha_tecnica[capacidad_electrica]">Capacidad Eléctrica</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[capacidad_electrica]" name="ficha_tecnica[capacidad_electrica]" type="text" value="{{ old('ficha_tecnica.capacidad_electrica') }}" placeholder="Ej: 75 KVA" />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="ficha_tecnica[agua_diametro]">Agua - Diámetro Acometida</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[agua_diametro]" name="ficha_tecnica[agua_diametro]" type="text" value="{{ old('ficha_tecnica.agua_diametro') }}" placeholder="Ej: 2\"" />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="ficha_tecnica[tuberia_aguas_lluvias]">Tubería Aguas Lluvias</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[tuberia_aguas_lluvias]" name="ficha_tecnica[tuberia_aguas_lluvias]" type="text" value="{{ old('ficha_tecnica.tuberia_aguas_lluvias') }}" placeholder="Ej: Tubería en gres de 6\"" />
                            </div>
                        </div>

                        {{-- Contra Incendios --}}
                        <div class="grid grid-cols-12 gap-4 mb-4">
                            <div class="col-span-12">
                                <h4 class="text-sm font-semibold text-slate-700">Sistema Contra Incendios</h4>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="ficha_tecnica[cajas_inspeccion_pluvial]">Cajas Inspección Pluvial</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[cajas_inspeccion_pluvial]" name="ficha_tecnica[cajas_inspeccion_pluvial]" type="text" value="{{ old('ficha_tecnica.cajas_inspeccion_pluvial') }}" placeholder="Ej: Seis cajas (1.2x1.2)" />
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <x-base.form-label for="ficha_tecnica[red_contra_incendios]">Red Contra Incendios</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[red_contra_incendios]" name="ficha_tecnica[red_contra_incendios]" type="text" value="{{ old('ficha_tecnica.red_contra_incendios') }}" placeholder="Ej: Tubería de 3\", salida 1-1/2\"" />
                            </div>
                            <div class="col-span-12 sm:col-span-2">
                                <x-base.form-label for="ficha_tecnica[gabinetes_ci]">Gabinetes C.I.</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[gabinetes_ci]" name="ficha_tecnica[gabinetes_ci]" type="number" min="0" value="{{ old('ficha_tecnica.gabinetes_ci') }}" placeholder="Ej: 6" />
                            </div>
                        </div>

                        {{-- Estructura y Acabados --}}
                        <div class="grid grid-cols-12 gap-4 mb-4">
                            <div class="col-span-12">
                                <h4 class="text-sm font-semibold text-slate-700">Estructura y Acabados</h4>
                            </div>
                            <div class="col-span-12">
                                <x-base.form-label for="ficha_tecnica[cubierta]">Cubierta</x-base.form-label>
                                <x-base.form-textarea class="w-full" id="ficha_tecnica[cubierta]" name="ficha_tecnica[cubierta]" rows="2">{{ old('ficha_tecnica.cubierta') }}</x-base.form-textarea>
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <x-base.form-label for="ficha_tecnica[muros]">Muros</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[muros]" name="ficha_tecnica[muros]" type="text" value="{{ old('ficha_tecnica.muros') }}" />
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <x-base.form-label for="ficha_tecnica[acabados]">Acabados</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[acabados]" name="ficha_tecnica[acabados]" type="text" value="{{ old('ficha_tecnica.acabados') }}" />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="ficha_tecnica[pisos]">Pisos</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[pisos]" name="ficha_tecnica[pisos]" type="text" value="{{ old('ficha_tecnica.pisos') }}" />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="ficha_tecnica[blindaje_juntas]">Blindaje / Juntas</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[blindaje_juntas]" name="ficha_tecnica[blindaje_juntas]" type="text" value="{{ old('ficha_tecnica.blindaje_juntas') }}" />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="ficha_tecnica[estructura]">Estructura</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[estructura]" name="ficha_tecnica[estructura]" type="text" value="{{ old('ficha_tecnica.estructura') }}" />
                            </div>
                            <div class="col-span-12">
                                <x-base.form-label for="ficha_tecnica[puertas_ventanas]">Puertas y Ventanas</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[puertas_ventanas]" name="ficha_tecnica[puertas_ventanas]" type="text" value="{{ old('ficha_tecnica.puertas_ventanas') }}" />
                            </div>
                        </div>

                        {{-- Complementos --}}
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12">
                                <h4 class="text-sm font-semibold text-slate-700">Complementos</h4>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <x-base.form-check>
                                    <x-base.form-check.input type="checkbox" id="ficha_tecnica_muelle" name="ficha_tecnica[muelle]" value="1" {{ old('ficha_tecnica.muelle') ? 'checked' : '' }} />
                                    <x-base.form-check.label for="ficha_tecnica_muelle">Muelle</x-base.form-check.label>
                                </x-base.form-check>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <x-base.form-check>
                                    <x-base.form-check.input type="checkbox" id="ficha_tecnica_mezzanine" name="ficha_tecnica[mezzanine]" value="1" {{ old('ficha_tecnica.mezzanine') ? 'checked' : '' }} />
                                    <x-base.form-check.label for="ficha_tecnica_mezzanine">Mezzanine</x-base.form-check.label>
                                </x-base.form-check>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <x-base.form-check>
                                    <x-base.form-check.input type="checkbox" id="ficha_tecnica_cocineta" name="ficha_tecnica[cocineta]" value="1" {{ old('ficha_tecnica.cocineta') ? 'checked' : '' }} />
                                    <x-base.form-check.label for="ficha_tecnica_cocineta">Cocineta</x-base.form-check.label>
                                </x-base.form-check>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <x-base.form-label for="ficha_tecnica[bloques_banos]">Bloques de Baños</x-base.form-label>
                                <x-base.form-input class="w-full" id="ficha_tecnica[bloques_banos]" name="ficha_tecnica[bloques_banos]" type="number" min="0" value="{{ old('ficha_tecnica.bloques_banos') }}" placeholder="0" />
                            </div>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="mt-5 text-right">
                        <a href="{{ route('gestion.inmuebles.index') }}">
                            <x-base.button class="mr-1 w-24" type="button"
                                variant="outline-secondary">Cancelar</x-base.button>
                        </a>
                        <x-base.button class="w-24" type="submit" variant="primary">Guardar</x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleFichaTecnica(tipoId) {
            const container = document.getElementById('fichaTecnicaContainer');
            // Asumimos que el tipo con id que corresponde a "Bodega" es el que tiene nombre "Bodega"
            // Pero usamos una opción: leer el texto seleccionado
            const select = document.getElementById('tipo_inmueble_id');
            const selectedOption = select.options[select.selectedIndex];
            const text = selectedOption.text.trim();
            if (text === 'Bodega') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        // Ejecutar al cargar para mostrar si ya hay un valor seleccionado
        document.addEventListener('DOMContentLoaded', function() {
            toggleFichaTecnica();
        });
    </script>
    @endpush
@endsection