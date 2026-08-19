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
                        {{-- CATEGORÍA PRIMERO (onchange) --}}
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="categoria_equipo_id">Categoría</x-base.form-label>
                            <x-base.form-select class="w-full" id="categoria_equipo_id" name="categoria_equipo_id" onchange="cargarTipos(this.value)">
                                <option value="">Seleccionar...</option>
                                @foreach($categoriasEquipo as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categoria_equipo_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        {{-- TIPO SEGUNDO (cargado dinámicamente) --}}
                        <div class="col-span-12 sm:col-span-4">
                            <x-base.form-label for="tipo_equipo_id">Tipo Equipo</x-base.form-label>
                            <x-base.form-select class="w-full" id="tipo_equipo_id" name="tipo_equipo_id">
                                <option value="">Seleccionar...</option>
                                {{-- Si hay old, se cargará vía JS --}}
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

                    {{-- Resto del formulario sin cambios (especificaciones, estado, etc.) --}}

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
        function cargarTipos(categoriaId) {
            if (!categoriaId) {
                document.getElementById('tipo_equipo_id').innerHTML = '<option value="">Seleccionar...</option>';
                return;
            }
            fetch('{{ route("gestion.equipos.tipos-por-categoria") }}?categoria_equipo_id=' + categoriaId)
                .then(r => r.json())
                .then(data => {
                    let select = document.getElementById('tipo_equipo_id');
                    select.innerHTML = '<option value="">Seleccionar...</option>';
                    data.forEach(tipo => {
                        select.innerHTML += `<option value="${tipo.id}">${tipo.nombre}</option>`;
                    });
                });
        }

        // Cargar tipos iniciales si hay una categoría preseleccionada
        document.addEventListener('DOMContentLoaded', function() {
            let catSelect = document.getElementById('categoria_equipo_id');
            if (catSelect.value) {
                cargarTipos(catSelect.value);
                // Si hay un old('tipo_equipo_id'), no lo podemos seleccionar hasta que se carguen los tipos.
                // Se podría pasar el valor antiguo y seleccionarlo después de la carga.
                // Simplificamos: el usuario seleccionará manualmente.
            }
        });
    </script>
    @endpush
@endsection