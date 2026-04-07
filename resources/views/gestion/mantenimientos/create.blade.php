@extends('../layouts/' . $layout)

@section('subhead')
    <title>Crear Mantenimiento - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Nuevo Mantenimiento</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('gestion.mantenimientos.index') }}" class="hover:text-primary">Mantenimientos</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>Crear</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                <form action="{{ route('gestion.mantenimientos.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="codigo">Código <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('codigo') border-danger @enderror" id="codigo" name="codigo" type="text" value="{{ old('codigo') }}" placeholder="MT-001" required />
                            @error('codigo') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="tipo_activo">Tipo de Activo <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select class="w-full" id="tipo_activo" name="tipo_activo" onchange="cargarActivos(this.value)" required>
                                <option value="">Seleccionar...</option>
                                <option value="inmueble" {{ old('tipo_activo') == 'inmueble' ? 'selected' : '' }}>Inmueble</option>
                                <option value="equipo" {{ old('tipo_activo') == 'equipo' ? 'selected' : '' }}>Equipo</option>
                            </x-base.form-select>
                            @error('tipo_activo') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="activo_id">Activo <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select class="w-full" id="activo_id" name="activo_id" required>
                                <option value="">Primero seleccione tipo...</option>
                            </x-base.form-select>
                            @error('activo_id') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="tipo_mantenimiento">Tipo Mantenimiento <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select class="w-full" id="tipo_mantenimiento" name="tipo_mantenimiento" required>
                                <option value="">Seleccionar...</option>
                                <option value="preventivo" {{ old('tipo_mantenimiento') == 'preventivo' ? 'selected' : '' }}>Preventivo</option>
                                <option value="correctivo" {{ old('tipo_mantenimiento') == 'correctivo' ? 'selected' : '' }}>Correctivo</option>
                                <option value="predictivo" {{ old('tipo_mantenimiento') == 'predictivo' ? 'selected' : '' }}>Predictivo</option>
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="estado">Estado <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select class="w-full" id="estado" name="estado" required>
                                <option value="programado" {{ old('estado', 'programado') == 'programado' ? 'selected' : '' }}>Programado</option>
                                <option value="en_proceso" {{ old('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="completado" {{ old('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="tipo_responsable">Tipo Responsable</x-base.form-label>
                            <x-base.form-select class="w-full" id="tipo_responsable" name="tipo_responsable">
                                <option value="">Seleccionar...</option>
                                <option value="Mincit" {{ old('tipo_responsable') == 'Mincit' ? 'selected' : '' }}>Mincit</option>
                                <option value="Operador ZFP" {{ old('tipo_responsable') == 'Operador ZFP' ? 'selected' : '' }}>Operador ZFP</option>
                                <option value="Usuario-calificado" {{ old('tipo_responsable') == 'Usuario-calificado' ? 'selected' : '' }}>Usuario Calificado</option>
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="fecha_programada">Fecha Programada</x-base.form-label>
                            <x-base.form-input class="w-full" id="fecha_programada" name="fecha_programada" type="date" value="{{ old('fecha_programada') }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="fecha_realizada">Fecha Realizada</x-base.form-label>
                            <x-base.form-input class="w-full" id="fecha_realizada" name="fecha_realizada" type="date" value="{{ old('fecha_realizada') }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="responsable">Responsable</x-base.form-label>
                            <x-base.form-input class="w-full" id="responsable" name="responsable" type="text" value="{{ old('responsable') }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="empresa_contratista">Empresa Contratista</x-base.form-label>
                            <x-base.form-input class="w-full" id="empresa_contratista" name="empresa_contratista" type="text" value="{{ old('empresa_contratista') }}" />
                        </div>
                        <div class="col-span-12">
                            <x-base.form-label for="descripcion">Descripción</x-base.form-label>
                            <x-base.form-textarea class="w-full" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</x-base.form-textarea>
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
                        <a href="{{ route('gestion.mantenimientos.index') }}">
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
                });
        }
    </script>
    @endpush
@endsection
