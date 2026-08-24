@extends('../layouts/' . $layout)

@section('subhead')
    <title>{{ $inmueble->nombre }} - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Detalle del Inmueble</h2>
        <a href="{{ route('gestion.inmuebles.edit', $inmueble) }}">
            <x-base.button variant="primary" class="mr-2 shadow-md">
                <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" /> Editar
            </x-base.button>
        </a>
        <a href="{{ route('gestion.inmuebles.index') }}">
            <x-base.button variant="outline-secondary">
                <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft" /> Volver
            </x-base.button>
        </a>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('gestion.inmuebles.index') }}" class="hover:text-primary">Inmuebles</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>{{ $inmueble->codigo }}</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        {{-- Info principal --}}
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                <div class="flex items-center border-b border-slate-200/60 pb-5 dark:border-darkmode-400">
                    <div>
                        <div class="text-base font-medium">{{ $inmueble->nombre }}</div>
                        <div class="mt-1 text-slate-500">{{ $inmueble->codigo }}</div>
                    </div>
                    <div class="ml-auto">{!! $inmueble->estado_badge !!}</div>
                </div>
                <div class="mt-5 grid grid-cols-12 gap-4">
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Bloque</div>
                        <div class="mt-1 font-medium">{{ $inmueble->bloque?->nombre ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Tipo</div>
                        <div class="mt-1 font-medium">{{ $inmueble->tipoInmueble?->nombre ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Nivel Deterioro</div>
                        <div class="mt-1 font-medium">{{ $inmueble->nivelDeterioro?->nombre ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Área (m²)</div>
                        <div class="mt-1 font-medium">{{ $inmueble->area_m2 ? number_format($inmueble->area_m2, 2) : '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Área Construida (m²)</div>
                        <div class="mt-1 font-medium">{{ $inmueble->area_construida_m2 ? number_format($inmueble->area_construida_m2, 2) : '—' }}</div>
                    </div>
                    <div class="col-span-12">
                        <div class="text-xs text-slate-500">Dirección</div>
                        <div class="mt-1 font-medium">{{ $inmueble->direccion ?? '—' }}</div>
                    </div>
                    @if($inmueble->observaciones)
                    <div class="col-span-12">
                        <div class="text-xs text-slate-500">Observaciones</div>
                        <div class="mt-1">{{ $inmueble->observaciones }}</div>
                    </div>
                    @endif
                </div>

                {{-- FICHA TÉCNICA --}}
                @if($inmueble->fichaTecnica)
                    <div class="mt-5 border-t border-slate-200/60 pt-5 dark:border-darkmode-400">
                        <h4 class="text-sm font-semibold text-slate-700 mb-3">Ficha Técnica de Bodega</h4>
                        <div class="grid grid-cols-12 gap-4">
                            {{-- Áreas --}}
                            <div class="col-span-12">
                                <h5 class="text-xs font-medium text-slate-500">Áreas</h5>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <div class="text-xs text-slate-500">Área Calificada</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->area_calificada ? number_format($inmueble->fichaTecnica->area_calificada, 2) : '—' }} m²</div>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <div class="text-xs text-slate-500">Área Útil</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->area_util ? number_format($inmueble->fichaTecnica->area_util, 2) : '—' }} m²</div>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <div class="text-xs text-slate-500">Área Bruta</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->area_bruta ? number_format($inmueble->fichaTecnica->area_bruta, 2) : '—' }} m²</div>
                            </div>

                            {{-- Servicios --}}
                            <div class="col-span-12 mt-2">
                                <h5 class="text-xs font-medium text-slate-500">Servicios</h5>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <div class="text-xs text-slate-500">Capacidad Eléctrica</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->capacidad_electrica ?? '—' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <div class="text-xs text-slate-500">Agua - Diámetro Acometida</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->agua_diametro ?? '—' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <div class="text-xs text-slate-500">Tubería Aguas Lluvias</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->tuberia_aguas_lluvias ?? '—' }}</div>
                            </div>

                            {{-- Contra Incendios --}}
                            <div class="col-span-12 mt-2">
                                <h5 class="text-xs font-medium text-slate-500">Sistema Contra Incendios</h5>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <div class="text-xs text-slate-500">Cajas Inspección Pluvial</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->cajas_inspeccion_pluvial ?? '—' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <div class="text-xs text-slate-500">Red Contra Incendios</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->red_contra_incendios ?? '—' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-2">
                                <div class="text-xs text-slate-500">Gabinetes C.I.</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->gabinetes_ci ?? '—' }}</div>
                            </div>

                            {{-- Estructura y Acabados --}}
                            <div class="col-span-12 mt-2">
                                <h5 class="text-xs font-medium text-slate-500">Estructura y Acabados</h5>
                            </div>
                            <div class="col-span-12">
                                <div class="text-xs text-slate-500">Cubierta</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->cubierta ?? '—' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <div class="text-xs text-slate-500">Muros</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->muros ?? '—' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <div class="text-xs text-slate-500">Acabados</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->acabados ?? '—' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <div class="text-xs text-slate-500">Pisos</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->pisos ?? '—' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <div class="text-xs text-slate-500">Blindaje / Juntas</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->blindaje_juntas ?? '—' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-4">
                                <div class="text-xs text-slate-500">Estructura</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->estructura ?? '—' }}</div>
                            </div>
                            <div class="col-span-12">
                                <div class="text-xs text-slate-500">Puertas y Ventanas</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->puertas_ventanas ?? '—' }}</div>
                            </div>

                            {{-- Complementos --}}
                            <div class="col-span-12 mt-2">
                                <h5 class="text-xs font-medium text-slate-500">Complementos</h5>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <div class="text-xs text-slate-500">Muelle</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->muelle ? 'Sí' : 'No' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <div class="text-xs text-slate-500">Mezzanine</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->mezzanine ? 'Sí' : 'No' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <div class="text-xs text-slate-500">Cocineta</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->cocineta ? 'Sí' : 'No' }}</div>
                            </div>
                            <div class="col-span-12 sm:col-span-3">
                                <div class="text-xs text-slate-500">Bloques de Baños</div>
                                <div class="font-medium">{{ $inmueble->fichaTecnica->bloques_banos ?? '—' }}</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Mapa --}}
            @if($inmueble->tiene_coordenadas)
            <div class="intro-y box mt-5 p-5">
                <div class="mb-3 flex items-center">
                    <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="MapPin" />
                    <span class="text-base font-medium">Ubicación</span>
                    <span class="ml-2 text-xs text-slate-500">{{ $inmueble->coordenadas }}</span>
                </div>
                <div id="map-show" style="height: 350px; border-radius: 8px;"></div>
            </div>
            @endif

            {{-- Equipos --}}
            @if($inmueble->equipos->count())
            <div class="intro-y box mt-5 p-5">
                <div class="mb-3 flex items-center">
                    <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="Wrench" />
                    <span class="text-base font-medium">Equipos ({{ $inmueble->equipos->count() }})</span>
                </div>
                <x-base.table class="border-separate border-spacing-y-[10px]">
                    <x-base.table.thead>
                        <x-base.table.tr>
                            <x-base.table.th class="border-b-0">Código</x-base.table.th>
                            <x-base.table.th class="border-b-0">Nombre</x-base.table.th>
                            <x-base.table.th class="border-b-0">Tipo</x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                    <x-base.table.tbody>
                        @foreach($inmueble->equipos->take(10) as $equipo)
                        <x-base.table.tr>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">{{ $equipo->codigo }}</x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">
                                <a href="{{ route('gestion.equipos.show', $equipo) }}" class="text-primary">{{ Str::limit($equipo->nombre, 50) }}</a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">{{ $equipo->tipoEquipo?->nombre ?? '—' }}</x-base.table.td>
                        </x-base.table.tr>
                        @endforeach
                    </x-base.table.tbody>
                </x-base.table>
            </div>
            @endif
        </div>
    </div>

    @if($inmueble->tiene_coordenadas)
    @push('scripts')
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('map-show').setView([{{ $inmueble->latitud }}, {{ $inmueble->longitud }}], 17);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        L.marker([{{ $inmueble->latitud }}, {{ $inmueble->longitud }}])
            .addTo(map)
            .bindPopup('<strong>{{ addslashes($inmueble->nombre) }}</strong><br>{{ $inmueble->codigo }}')
            .openPopup();
    });
</script>
    @endpush
    @endif
@endsection