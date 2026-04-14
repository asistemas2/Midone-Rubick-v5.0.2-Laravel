@extends('../layouts/' . $layout)

@section('subhead')
    <title>Asignar Equipo - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Asignar Equipo a Inmueble</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('gestion.asignaciones.index') }}" class="hover:text-primary">Asignación de Equipos</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>Asignar</span>
    </div>

    @if ($errors->any())
        <div class="intro-y mt-4">
            <div class="rounded-md bg-danger/20 px-5 py-3 text-danger">
                <x-base.lucide class="mr-2 inline h-4 w-4" icon="XCircle" />
                <ul class="mt-1 list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                <form action="{{ route('gestion.asignaciones.store') }}" method="POST">
                    @csrf

                    {{-- Selección de Equipo --}}
                    <div class="border-b border-slate-200/60 pb-4 mb-4">
                        <h3 class="text-base font-medium">
                            <x-base.lucide class="mr-2 inline h-5 w-5 text-primary" icon="Package" />
                            Seleccionar Equipo
                        </h3>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12">
                            <x-base.form-label for="equipo_id">Equipo sin asignar <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select class="w-full @error('equipo_id') border-danger @enderror" id="equipo_id" name="equipo_id" onchange="mostrarDetalleEquipo(this.value)">
                                <option value="">Seleccionar equipo...</option>
                                @foreach($equiposSinAsignar as $eq)
                                    <option value="{{ $eq->id }}"
                                        data-codigo="{{ $eq->codigo }}"
                                        data-tipo="{{ $eq->tipoEquipo?->nombre ?? '—' }}"
                                        data-categoria="{{ $eq->categoriaEquipo?->nombre ?? '—' }}"
                                        data-marca="{{ $eq->marca?->nombre ?? '—' }}"
                                        data-modelo="{{ $eq->modelo ?? '—' }}"
                                        {{ (old('equipo_id', $equipoSeleccionado?->id) == $eq->id) ? 'selected' : '' }}>
                                        {{ $eq->codigo }} — {{ $eq->nombre }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                            @error('equipo_id') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Detalle del equipo seleccionado --}}
                    <div id="detalle-equipo" class="mt-4 rounded-md bg-slate-50 p-4 dark:bg-darkmode-400" style="display: none;">
                        <div class="mb-2 text-sm font-medium text-slate-600 dark:text-slate-300">
                            <x-base.lucide class="mr-1 inline h-4 w-4" icon="Info" /> Detalle del equipo seleccionado
                        </div>
                        <div class="grid grid-cols-12 gap-3 text-sm">
                            <div class="col-span-6 sm:col-span-3">
                                <div class="text-xs text-slate-500">Código</div>
                                <div id="det-codigo" class="mt-1 font-medium">—</div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <div class="text-xs text-slate-500">Tipo</div>
                                <div id="det-tipo" class="mt-1 font-medium">—</div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <div class="text-xs text-slate-500">Categoría</div>
                                <div id="det-categoria" class="mt-1 font-medium">—</div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <div class="text-xs text-slate-500">Marca / Modelo</div>
                                <div id="det-marca" class="mt-1 font-medium">—</div>
                            </div>
                        </div>
                    </div>

                    {{-- Selección de Inmueble --}}
                    <div class="border-b border-slate-200/60 pb-4 mb-4 mt-6">
                        <h3 class="text-base font-medium">
                            <x-base.lucide class="mr-2 inline h-5 w-5 text-primary" icon="Building2" />
                            Seleccionar Inmueble Destino
                        </h3>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12">
                            <x-base.form-label for="inmueble_id">Inmueble <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select class="w-full @error('inmueble_id') border-danger @enderror" id="inmueble_id" name="inmueble_id">
                                <option value="">Seleccionar inmueble...</option>
                                @foreach($inmuebles as $inm)
                                    <option value="{{ $inm->id }}" {{ old('inmueble_id') == $inm->id ? 'selected' : '' }}>
                                        {{ $inm->nombre }} — {{ $inm->bloque?->nombre ?? 'Sin bloque' }} ({{ $inm->equipos_count }} equipos)
                                    </option>
                                @endforeach
                            </x-base.form-select>
                            @error('inmueble_id') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-5 text-right">
                        <a href="{{ route('gestion.asignaciones.index') }}">
                            <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button>
                        </a>
                        <x-base.button class="w-32" type="submit" variant="primary">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="Link" /> Asignar
                        </x-base.button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Panel lateral informativo --}}
        <div class="intro-y col-span-12 lg:col-span-4">
            <div class="intro-y box p-5">
                <div class="mb-3 flex items-center">
                    <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="HelpCircle" />
                    <span class="text-base font-medium">Información</span>
                </div>
                <div class="text-sm text-slate-500">
                    <p class="mb-2">Seleccione un equipo que aún no esté asignado y el inmueble al que desea asignarlo.</p>
                    <p class="mb-2">Solo se muestran equipos activos sin asignación actual.</p>
                    <p>Si necesita reasignar un equipo ya asignado, utilice la opción <strong>"Reasignar"</strong> desde el listado principal.</p>
                </div>
            </div>
            <div class="intro-y box mt-5 p-5">
                <div class="mb-3 flex items-center">
                    <x-base.lucide class="mr-2 h-5 w-5 text-warning" icon="AlertTriangle" />
                    <span class="text-base font-medium">Resumen</span>
                </div>
                <div class="text-sm">
                    <div class="flex items-center justify-between border-b py-2">
                        <span class="text-slate-500">Equipos sin asignar:</span>
                        <span class="font-medium">{{ $equiposSinAsignar->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b py-2">
                        <span class="text-slate-500">Inmuebles disponibles:</span>
                        <span class="font-medium">{{ $inmuebles->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function mostrarDetalleEquipo(equipoId) {
            const detalle = document.getElementById('detalle-equipo');
            if (!equipoId) {
                detalle.style.display = 'none';
                return;
            }
            const option = document.querySelector('#equipo_id option[value="' + equipoId + '"]');
            if (option) {
                document.getElementById('det-codigo').textContent = option.dataset.codigo;
                document.getElementById('det-tipo').textContent = option.dataset.tipo;
                document.getElementById('det-categoria').textContent = option.dataset.categoria;
                document.getElementById('det-marca').textContent = option.dataset.marca + ' / ' + option.dataset.modelo;
                detalle.style.display = 'block';
            }
        }
        // Mostrar detalle si ya hay equipo pre-seleccionado
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('equipo_id');
            if (select.value) mostrarDetalleEquipo(select.value);
        });
    </script>
    @endpush
@endsection
