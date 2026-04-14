@extends('../layouts/' . $layout)

@section('subhead')
    <title>Detalle Asignación - {{ $equipo->nombre }} - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Detalle de Asignación</h2>
        @if($equipo->inmueble_id)
            <a href="{{ route('gestion.asignaciones.edit', $equipo) }}">
                <x-base.button variant="primary" class="mr-2 shadow-md">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowRightLeft" /> Reasignar
                </x-base.button>
            </a>
        @else
            <a href="{{ route('gestion.asignaciones.create', ['equipo_id' => $equipo->id]) }}">
                <x-base.button variant="success" class="mr-2 shadow-md">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Link" /> Asignar
                </x-base.button>
            </a>
        @endif
        <a href="{{ route('gestion.asignaciones.index') }}">
            <x-base.button variant="outline-secondary">
                <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft" /> Volver
            </x-base.button>
        </a>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        {{-- Panel Equipo --}}
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <div class="flex items-center border-b border-slate-200/60 pb-5 dark:border-darkmode-400">
                    <x-base.lucide class="mr-3 h-6 w-6 text-primary" icon="Package" />
                    <div>
                        <div class="text-base font-medium">{{ $equipo->nombre }}</div>
                        <div class="mt-1 text-slate-500">{{ $equipo->codigo }}</div>
                    </div>
                    <div class="ml-auto">
                        @if($equipo->inmueble_id)
                            <span class="rounded-full bg-success/20 px-3 py-1 text-sm text-success">
                                <x-base.lucide class="mr-1 inline h-3 w-3" icon="Check" /> Asignado
                            </span>
                        @else
                            <span class="rounded-full bg-warning/20 px-3 py-1 text-sm text-warning">
                                <x-base.lucide class="mr-1 inline h-3 w-3" icon="AlertCircle" /> Sin Asignar
                            </span>
                        @endif
                    </div>
                </div>
                <div class="mt-5 grid grid-cols-12 gap-4">
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Tipo</div>
                        <div class="mt-1 font-medium">{{ $equipo->tipoEquipo?->nombre ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Categoría</div>
                        <div class="mt-1 font-medium">{{ $equipo->categoriaEquipo?->nombre ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Marca</div>
                        <div class="mt-1 font-medium">{{ $equipo->marca?->nombre ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Modelo</div>
                        <div class="mt-1 font-medium">{{ $equipo->modelo ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">No. Serie</div>
                        <div class="mt-1 font-medium">{{ $equipo->no_serie ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Estado</div>
                        <div class="mt-1">
                            @if($equipo->estadoEquipo)
                                <span class="rounded-full px-2 py-1 text-xs" style="background-color: {{ $equipo->estadoEquipo->color_hex }}20; color: {{ $equipo->estadoEquipo->color_hex }}">{{ $equipo->estadoEquipo->nombre }}</span>
                            @else
                                —
                            @endif
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Criticidad</div>
                        <div class="mt-1">
                            @if($equipo->criticidad)
                                <span class="rounded-full px-2 py-1 text-xs" style="background-color: {{ $equipo->criticidad->color_hex }}20; color: {{ $equipo->criticidad->color_hex }}">{{ $equipo->criticidad->nombre }}</span>
                            @else
                                —
                            @endif
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Ubicación Específica</div>
                        <div class="mt-1 font-medium">{{ $equipo->ubicacion_especifica ?? '—' }}</div>
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <a href="{{ route('gestion.equipos.show', $equipo) }}" class="text-sm text-primary hover:underline">
                        Ver ficha completa del equipo →
                    </a>
                </div>
            </div>
        </div>

        {{-- Panel Inmueble --}}
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <div class="flex items-center border-b border-slate-200/60 pb-5 dark:border-darkmode-400">
                    <x-base.lucide class="mr-3 h-6 w-6 text-primary" icon="Building2" />
                    <div>
                        <div class="text-base font-medium">
                            {{ $equipo->inmueble?->nombre ?? 'Sin Inmueble Asignado' }}
                        </div>
                        @if($equipo->inmueble)
                            <div class="mt-1 text-slate-500">{{ $equipo->inmueble->codigo }}</div>
                        @endif
                    </div>
                </div>
                @if($equipo->inmueble)
                    <div class="mt-5 grid grid-cols-12 gap-4">
                        <div class="col-span-6 sm:col-span-4">
                            <div class="text-xs text-slate-500">Bloque</div>
                            <div class="mt-1 font-medium">{{ $equipo->inmueble->bloque?->nombre ?? '—' }}</div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <div class="text-xs text-slate-500">Tipo</div>
                            <div class="mt-1 font-medium">{{ $equipo->inmueble->tipoInmueble?->nombre ?? '—' }}</div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <div class="text-xs text-slate-500">Estado</div>
                            <div class="mt-1">{!! $equipo->inmueble->estado_badge !!}</div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <div class="text-xs text-slate-500">Área (m²)</div>
                            <div class="mt-1 font-medium">{{ $equipo->inmueble->area_m2 ? number_format($equipo->inmueble->area_m2, 2) : '—' }}</div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <div class="text-xs text-slate-500">Dirección</div>
                            <div class="mt-1 font-medium">{{ Str::limit($equipo->inmueble->direccion, 30) ?? '—' }}</div>
                        </div>
                    </div>

                    {{-- Otros equipos en este inmueble --}}
                    @if($equipo->inmueble->equipos && $equipo->inmueble->equipos->count() > 0)
                        <div class="mt-5 border-t border-slate-200/60 pt-4 dark:border-darkmode-400">
                            <div class="mb-3 text-sm font-medium text-slate-600 dark:text-slate-300">
                                <x-base.lucide class="mr-1 inline h-4 w-4" icon="Package" />
                                Otros equipos en este inmueble ({{ $equipo->inmueble->equipos->count() }})
                            </div>
                            <div class="space-y-2">
                                @foreach($equipo->inmueble->equipos->take(5) as $otroEquipo)
                                    <div class="flex items-center rounded bg-slate-50 px-3 py-2 dark:bg-darkmode-400">
                                        <span class="rounded bg-slate-200 px-2 py-0.5 text-xs dark:bg-darkmode-300">{{ $otroEquipo->codigo }}</span>
                                        <span class="ml-2 text-sm">{{ Str::limit($otroEquipo->nombre, 30) }}</span>
                                        <span class="ml-auto text-xs text-slate-500">{{ $otroEquipo->tipoEquipo?->nombre ?? '' }}</span>
                                    </div>
                                @endforeach
                                @if($equipo->inmueble->equipos->count() > 5)
                                    <div class="text-center text-xs text-slate-500">
                                        y {{ $equipo->inmueble->equipos->count() - 5 }} más...
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="mt-4 text-right">
                        <a href="{{ route('gestion.inmuebles.show', $equipo->inmueble) }}" class="text-sm text-primary hover:underline">
                            Ver ficha completa del inmueble →
                        </a>
                    </div>
                @else
                    <div class="mt-5 text-center py-8 text-slate-400">
                        <x-base.lucide class="mx-auto h-12 w-12 text-slate-300" icon="Building2" />
                        <p class="mt-2">Este equipo no tiene inmueble asignado.</p>
                        <a href="{{ route('gestion.asignaciones.create', ['equipo_id' => $equipo->id]) }}" class="mt-3 inline-block text-sm text-primary hover:underline">
                            Asignar ahora →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
