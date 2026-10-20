@extends('../layouts/' . $layout)

@section('subhead')
    <title>{{ $equipo->nombre }} - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Detalle del Equipo</h2>
        <a href="{{ route('gestion.equipos.edit', $equipo) }}">
            <x-base.button variant="primary" class="mr-2 shadow-md">
                <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" /> Editar
            </x-base.button>
        </a>
        <a href="{{ route('gestion.equipos.index') }}">
            <x-base.button variant="outline-secondary">
                <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft" /> Volver
            </x-base.button>
        </a>
    </div>

    @php
        // Vencimientos calculados desde la fecha de adquisición (o instalación)
        $fechaBase = $equipo->fecha_adquisicion ?? $equipo->fecha_instalacion;
        $finGarantia = $fechaBase && $equipo->garantia_meses ? $fechaBase->copy()->addMonths($equipo->garantia_meses) : null;
        $finVidaUtil = $fechaBase && $equipo->vida_util_anios ? $fechaBase->copy()->addYears($equipo->vida_util_anios) : null;
        $dato = fn ($valor) => filled($valor) ? $valor : '—';
    @endphp

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">

            {{-- BLOQUE 1: IDENTIFICACIÓN Y DATOS TÉCNICOS --}}
            <div class="intro-y box p-5">
                <div class="flex flex-wrap items-center gap-2 border-b border-slate-200/60 pb-5 dark:border-darkmode-400">
                    <div class="mr-auto">
                        <div class="text-base font-medium">{{ $equipo->nombre }}</div>
                        <div class="mt-1 text-slate-500">{{ $equipo->codigo }}</div>
                    </div>
                    @if($equipo->estadoEquipo)
                        <span class="rounded-full px-3 py-1 text-sm" style="background-color: {{ $equipo->estadoEquipo->color_hex }}20; color: {{ $equipo->estadoEquipo->color_hex }}">{{ $equipo->estadoEquipo->nombre }}</span>
                    @endif
                    <span @class(['rounded-full px-3 py-1 text-sm', 'bg-success/20 text-success' => $equipo->activo, 'bg-slate-200 text-slate-500' => !$equipo->activo])>
                        {{ $equipo->activo ? 'Registro activo' : 'Registro inactivo' }}
                    </span>
                </div>

                <div class="mt-5 grid grid-cols-12 gap-4">
                    {{-- Ubicación --}}
                    <div class="col-span-12 sm:col-span-6">
                        <div class="text-xs text-slate-500">Ubicación (Inmueble)</div>
                        <div class="mt-1 font-medium">
                            @if($equipo->inmueble)
                                <a href="{{ route('gestion.inmuebles.show', $equipo->inmueble) }}" class="text-primary">
                                    [{{ $equipo->inmueble->codigo }}] {{ $equipo->inmueble->nombre }}
                                </a>
                                @if($equipo->inmueble->bloque)
                                    <span class="text-slate-500">• {{ $equipo->inmueble->bloque->nombre }}</span>
                                @endif
                            @else
                                <span class="text-slate-500">Sin asignar</span>
                                <a href="{{ route('gestion.asignaciones.index', ['buscar' => $equipo->codigo]) }}" class="ml-2 text-xs text-primary">Asignar</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <div class="text-xs text-slate-500">Ubicación específica</div>
                        <div class="mt-1 font-medium">{{ $dato($equipo->ubicacion_especifica) }}</div>
                    </div>

                    @foreach ([
                        'Tipo' => $equipo->tipoEquipo?->nombre,
                        'Categoría' => $equipo->categoriaEquipo?->nombre,
                        'Marca' => $equipo->marca?->nombre,
                        'Modelo' => $equipo->modelo,
                        'No. Serie' => $equipo->no_serie,
                    ] as $etiqueta => $valor)
                        <div class="col-span-6 sm:col-span-4">
                            <div class="text-xs text-slate-500">{{ $etiqueta }}</div>
                            <div class="mt-1 font-medium">{{ $dato($valor) }}</div>
                        </div>
                    @endforeach
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

                    @if($equipo->descripcion)
                        <div class="col-span-12">
                            <div class="text-xs text-slate-500">Descripción</div>
                            <div class="mt-1">{{ $equipo->descripcion }}</div>
                        </div>
                    @endif
                </div>

                <div class="mt-5 border-t border-slate-200/60 pt-5 dark:border-darkmode-400">
                    <div class="mb-3 font-medium">Especificaciones técnicas</div>
                    <div class="grid grid-cols-12 gap-4">
                        @foreach ([
                            'Capacidad' => $equipo->capacidad,
                            'Voltaje' => $equipo->voltaje,
                            'Potencia' => $equipo->potencia,
                            'Frecuencia' => $equipo->frecuencia,
                        ] as $etiqueta => $valor)
                            <div class="col-span-6 sm:col-span-3">
                                <div class="text-xs text-slate-500">{{ $etiqueta }}</div>
                                <div class="mt-1 font-medium">{{ $dato($valor) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- BLOQUE 2: ADQUISICIÓN, GARANTÍA DE FÁBRICA Y MANTENIMIENTO --}}
            <div class="intro-y box mt-5 p-5">
                <div class="mb-3 flex items-center border-b border-slate-200/60 pb-3 dark:border-darkmode-400">
                    <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="ClipboardList" />
                    <span class="text-base font-medium">Adquisición y Ciclo de Vida</span>
                </div>
                <div class="grid grid-cols-12 gap-4">
                    @foreach ([
                        'Proveedor' => $equipo->proveedor,
                        'Fecha de adquisición' => $equipo->fecha_adquisicion?->format('d/m/Y'),
                        'Fecha de instalación' => $equipo->fecha_instalacion?->format('d/m/Y'),
                        'Responsable' => $equipo->responsable,
                    ] as $etiqueta => $valor)
                        <div class="col-span-6 sm:col-span-3">
                            <div class="text-xs text-slate-500">{{ $etiqueta }}</div>
                            <div class="mt-1 font-medium">{{ $dato($valor) }}</div>
                        </div>
                    @endforeach
                    <div class="col-span-6 sm:col-span-3">
                        <div class="text-xs text-slate-500">Garantía de fábrica</div>
                        <div class="mt-1 font-medium">
                            {{ $equipo->garantia_meses ? $equipo->garantia_meses . ' meses' : '—' }}
                            @if($finGarantia)
                                <div @class(['text-xs font-normal', 'text-success' => $finGarantia->isFuture(), 'text-danger' => $finGarantia->isPast()])>
                                    {{ $finGarantia->isFuture() ? 'Vence' : 'Venció' }} el {{ $finGarantia->format('d/m/Y') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <div class="text-xs text-slate-500">Vida útil</div>
                        <div class="mt-1 font-medium">
                            {{ $equipo->vida_util_anios ? $equipo->vida_util_anios . ' años' : '—' }}
                            @if($finVidaUtil)
                                <div @class(['text-xs font-normal', 'text-slate-500' => $finVidaUtil->isFuture(), 'text-danger' => $finVidaUtil->isPast()])>
                                    Hasta {{ $finVidaUtil->format('d/m/Y') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    @foreach ([
                        'Periodicidad de mantenimiento' => $equipo->periodicidadMantenimiento?->nombre,
                        'Último mantenimiento' => $equipo->ultimo_mantenimiento?->format('d/m/Y'),
                        'Próximo mantenimiento' => $equipo->proximo_mantenimiento?->format('d/m/Y'),
                    ] as $etiqueta => $valor)
                        <div class="col-span-6 sm:col-span-3">
                            <div class="text-xs text-slate-500">{{ $etiqueta }}</div>
                            <div class="mt-1 font-medium">{{ $dato($valor) }}</div>
                        </div>
                    @endforeach
                    @if($equipo->observaciones)
                        <div class="col-span-12">
                            <div class="text-xs text-slate-500">Observaciones</div>
                            <div class="mt-1">{{ $equipo->observaciones }}</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- BLOQUE 3: MANTENIMIENTOS --}}
            @include('gestion.partials._tabla-mantenimientos', ['mantenimientos' => $equipo->mantenimientos])

            {{-- BLOQUE 4: GARANTÍAS --}}
            @include('gestion.partials._tabla-garantias', ['garantias' => $equipo->garantias])
        </div>
    </div>
@endsection
