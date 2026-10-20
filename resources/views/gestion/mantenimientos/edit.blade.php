@extends('../layouts/' . $layout)

@section('subhead')
    <title>Editar Mantenimiento - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Editar Mantenimiento: {{ $mantenimiento->codigo }}</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('gestion.mantenimientos.index') }}" class="hover:text-primary">Mantenimientos</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>Editar</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-10">
            <div class="intro-y box p-5">
                <form action="{{ route('gestion.mantenimientos.update', $mantenimiento) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- SECCIÓN 1: INFORMACIÓN BÁSICA --}}
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ClipboardList" />
                            Información Básica
                        </div>
                        <div class="mt-5 grid grid-cols-12 gap-4">
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="codigo">Código</x-base.form-label>
                                <x-base.form-input class="w-full" id="codigo" type="text" value="{{ $mantenimiento->codigo }}" disabled />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="tipo_activo">Tipo de Activo <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-select class="w-full" id="tipo_activo" name="tipo_activo" onchange="cargarActivos(this.value)" required>
                                    <option value="inmueble" {{ old('tipo_activo', $mantenimiento->tipo_activo) == 'inmueble' ? 'selected' : '' }}>Inmueble</option>
                                    <option value="equipo" {{ old('tipo_activo', $mantenimiento->tipo_activo) == 'equipo' ? 'selected' : '' }}>Equipo</option>
                                </x-base.form-select>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="activo_id">Activo <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-select class="w-full" id="activo_id" name="activo_id" required>
                                    <option value="{{ $mantenimiento->activo_id }}" selected>{{ $mantenimiento->nombre_activo }} (actual)</option>
                                </x-base.form-select>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="tipo_mantenimiento">Tipo Mantenimiento <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-select class="w-full" id="tipo_mantenimiento" name="tipo_mantenimiento" required>
                                    <option value="preventivo" {{ old('tipo_mantenimiento', $mantenimiento->tipo_mantenimiento) == 'preventivo' ? 'selected' : '' }}>Preventivo</option>
                                    <option value="correctivo" {{ old('tipo_mantenimiento', $mantenimiento->tipo_mantenimiento) == 'correctivo' ? 'selected' : '' }}>Correctivo</option>
                                    <option value="predictivo" {{ old('tipo_mantenimiento', $mantenimiento->tipo_mantenimiento) == 'predictivo' ? 'selected' : '' }}>Predictivo</option>
                                </x-base.form-select>
                            </div>
                            <div class="col-span-12">
                                <x-base.form-label for="descripcion">Descripción</x-base.form-label>
                                <x-base.form-textarea class="w-full" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $mantenimiento->descripcion) }}</x-base.form-textarea>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN 2: CLASIFICACIÓN Y RIESGO --}}
                    <div class="intro-y box mt-5 rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="AlertTriangle" />
                            Clasificación del Riesgo
                        </div>

                        <div class="mt-5">
                            {{-- Criterio Mantenimiento (tarjetas seleccionables) --}}
                            <div>
                                <x-base.form-label>
                                    <div class="text-left">
                                        <div class="font-medium">Criterio Mantenimiento</div>
                                    </div>
                                </x-base.form-label>

                                <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                                    @php
                                        $criterioActual = old('criterio_mantenimiento', $mantenimiento->criterio_mantenimiento);
                                    @endphp
                                    @foreach([
                                        'riesgo_vida' => ['label' => 'Riesgo de Vida', 'icon' => 'HeartPulse'],
                                        'riesgo_operacional' => ['label' => 'Riesgo Operacional', 'icon' => 'Activity'],
                                        'riesgo_sancionatorio' => ['label' => 'Riesgo Sancionatorio', 'icon' => 'Scale'],
                                        'riesgo_activo' => ['label' => 'Riesgo sobre Activo', 'icon' => 'Package'],
                                    ] as $value => $item)
                                        <label
                                            for="criterio-{{ $value }}"
                                            class="group inline-flex cursor-pointer items-center gap-2 rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-primary hover:text-primary has-[:checked]:border-primary has-[:checked]:bg-primary/5 has-[:checked]:text-primary dark:border-darkmode-400 dark:bg-darkmode-600 dark:text-slate-300 dark:hover:border-primary dark:has-[:checked]:bg-primary/10"
                                        >
                                            <input
                                                type="radio"
                                                id="criterio-{{ $value }}"
                                                name="criterio_mantenimiento"
                                                value="{{ $value }}"
                                                class="hidden"
                                                onchange="cargarCriticidades('{{ $value }}')"
                                                {{ $criterioActual == $value ? 'checked' : '' }}
                                            />
                                            <x-base.lucide class="h-4 w-4" icon="{{ $item['icon'] }}" />
                                            <span class="whitespace-nowrap">{{ $item['label'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Criticidad --}}
                            <div id="wrapper-criticidad" class="mt-5" style="display: {{ $criterioActual ? 'block' : 'none' }};">
                                <x-base.form-label for="criticidad_mantenimiento_id">
                                    <div class="text-left">
                                        <div class="font-medium">Criticidad</div>
                                    </div>
                                </x-base.form-label>
                                <x-base.form-select class="mt-2 w-full" id="criticidad_mantenimiento_id" name="criticidad_mantenimiento_id">
                                    <option value="">Seleccionar criticidad...</option>
                                </x-base.form-select>
                            </div>

                            {{-- Presupuesto Aprobado --}}
                            <div class="mt-5">
                                <x-base.form-label for="presupuesto_aprobado">
                                    <div class="text-left">
                                        <div class="font-medium">Presupuesto Aprobado</div>
                                    </div>
                                </x-base.form-label>
                                <x-base.input-group class="mt-2" inputGroup>
                                    <x-base.input-group.text>$</x-base.input-group.text>
                                    <x-base.form-input class="w-full" id="presupuesto_aprobado" name="presupuesto_aprobado" type="number" step="0.01" min="0" value="{{ old('presupuesto_aprobado', $mantenimiento->presupuesto_aprobado) }}" placeholder="0.00" />
                                </x-base.input-group>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN 3: RESPONSABLES Y FECHAS --}}
                    <div class="intro-y box mt-5 rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="Users" />
                            Responsables y Fechas
                        </div>
                        <div class="mt-5 grid grid-cols-12 gap-4">
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="estado">Estado <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-select class="w-full" id="estado" name="estado" required>
                                    <option value="programado" {{ old('estado', $mantenimiento->estado) == 'programado' ? 'selected' : '' }}>Programado</option>
                                    <option value="en_proceso" {{ old('estado', $mantenimiento->estado) == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="completado" {{ old('estado', $mantenimiento->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                                    <option value="cancelado" {{ old('estado', $mantenimiento->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </x-base.form-select>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="tipo_responsable">Tipo Responsable</x-base.form-label>
                                <x-base.form-select class="w-full" id="tipo_responsable" name="tipo_responsable">
                                    <option value="">Seleccionar...</option>
                                    <option value="Mincit" {{ old('tipo_responsable', $mantenimiento->tipo_responsable) == 'Mincit' ? 'selected' : '' }}>Mincit</option>
                                    <option value="Operador ZFP" {{ old('tipo_responsable', $mantenimiento->tipo_responsable) == 'Operador ZFP' ? 'selected' : '' }}>Operador ZFP</option>
                                    <option value="Usuario-calificado" {{ old('tipo_responsable', $mantenimiento->tipo_responsable) == 'Usuario-calificado' ? 'selected' : '' }}>Usuario Calificado</option>
                                </x-base.form-select>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="responsable">Responsable</x-base.form-label>
                                <x-base.form-input class="w-full" id="responsable" name="responsable" type="text" value="{{ old('responsable', $mantenimiento->responsable) }}" />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="fecha_programada">Fecha Programada</x-base.form-label>
                                <x-base.form-input class="w-full" id="fecha_programada" name="fecha_programada" type="date" value="{{ old('fecha_programada', $mantenimiento->fecha_programada?->format('Y-m-d')) }}" />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="fecha_realizada">Fecha Realizada</x-base.form-label>
                                <x-base.form-input class="w-full" id="fecha_realizada" name="fecha_realizada" type="date" value="{{ old('fecha_realizada', $mantenimiento->fecha_realizada?->format('Y-m-d')) }}" />
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <x-base.form-label for="empresa_contratista">Empresa Contratista</x-base.form-label>
                                <x-base.form-input class="w-full" id="empresa_contratista" name="empresa_contratista" type="text" value="{{ old('empresa_contratista', $mantenimiento->empresa_contratista) }}" />
                            </div>
                            <div class="col-span-12">
                                <x-base.form-label for="observaciones">Observaciones</x-base.form-label>
                                <x-base.form-textarea class="w-full" id="observaciones" name="observaciones" rows="3">{{ old('observaciones', $mantenimiento->observaciones) }}</x-base.form-textarea>
                            </div>
                            <div class="col-span-12">
                                <x-base.form-switch class="mt-2">
                                    <input type="hidden" name="activo" value="0" />
                                    <x-base.form-switch.input type="checkbox" name="activo" value="1" :checked="old('activo', $mantenimiento->activo)" />
                                    <x-base.form-switch.label>Activo</x-base.form-switch.label>
                                </x-base.form-switch>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                        <a href="{{ route('gestion.mantenimientos.index') }}">
                            <x-base.button class="w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52" type="button" variant="outline-secondary">Cancelar</x-base.button>
                        </a>
                        <x-base.button class="w-full py-3 md:w-52" type="submit" variant="primary">Actualizar Mantenimiento</x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const CRITICIDAD_ACTUAL = {{ $mantenimiento->criticidad_mantenimiento_id ?? 'null' }};

        function cargarActivos(tipo) {
            if (!tipo) return;
            fetch('{{ route("gestion.mantenimientos.activos-por-tipo") }}?tipo=' + tipo)
                .then(r => r.json())
                .then(data => {
                    let select = document.getElementById('activo_id');
                    select.innerHTML = '<option value="">Seleccionar...</option>';
                    data.forEach(item => {
                        select.innerHTML += `<option value="${item.id}">[${item.codigo}] ${item.nombre}</option>`;
                    });
                    select.value = '{{ $mantenimiento->activo_id }}';
                });
        }

        function cargarCriticidades(criterio, preseleccionar = null) {
            const wrapper = document.getElementById('wrapper-criticidad');
            const select = document.getElementById('criticidad_mantenimiento_id');

            if (!criterio) {
                wrapper.style.display = 'none';
                select.innerHTML = '<option value="">Seleccionar criticidad...</option>';
                return;
            }

            wrapper.style.display = 'block';
            select.innerHTML = '<option value="">Cargando...</option>';

            fetch('{{ route("gestion.mantenimientos.criticidades-por-criterio") }}?criterio=' + criterio)
                .then(r => r.json())
                .then(data => {
                    select.innerHTML = '<option value="">Seleccionar criticidad...</option>';
                    data.forEach(item => {
                        const selected = (preseleccionar && preseleccionar == item.id) ? 'selected' : '';
                        select.innerHTML += `<option value="${item.id}" ${selected} style="color:${item.color_hex}">${item.nombre}</option>`;
                    });
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const criterioSeleccionado = document.querySelector('input[name="criterio_mantenimiento"]:checked');
            if (criterioSeleccionado) {
                cargarCriticidades(criterioSeleccionado.value, CRITICIDAD_ACTUAL);
            }
        });
    </script>
    @endpush
@endsection