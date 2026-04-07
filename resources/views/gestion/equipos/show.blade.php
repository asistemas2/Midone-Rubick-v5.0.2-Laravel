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

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                <div class="flex items-center border-b border-slate-200/60 pb-5 dark:border-darkmode-400">
                    <div>
                        <div class="text-base font-medium">{{ $equipo->nombre }}</div>
                        <div class="mt-1 text-slate-500">{{ $equipo->codigo }}</div>
                    </div>
                    <div class="ml-auto">
                        @if($equipo->estadoEquipo)
                            <span class="rounded-full px-3 py-1 text-sm" style="background-color: {{ $equipo->estadoEquipo->color_hex }}20; color: {{ $equipo->estadoEquipo->color_hex }}">{{ $equipo->estadoEquipo->nombre }}</span>
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
                        <div class="text-xs text-slate-500">Capacidad</div>
                        <div class="mt-1 font-medium">{{ $equipo->capacidad ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Voltaje</div>
                        <div class="mt-1 font-medium">{{ $equipo->voltaje ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Ubicación</div>
                        <div class="mt-1 font-medium">{{ $equipo->ubicacion_especifica ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Periodicidad Mant.</div>
                        <div class="mt-1 font-medium">{{ $equipo->periodicidadMantenimiento?->nombre ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Último Mantenimiento</div>
                        <div class="mt-1 font-medium">{{ $equipo->ultimo_mantenimiento?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Próximo Mantenimiento</div>
                        <div class="mt-1 font-medium">{{ $equipo->proximo_mantenimiento?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                    @if($equipo->observaciones)
                    <div class="col-span-12">
                        <div class="text-xs text-slate-500">Observaciones</div>
                        <div class="mt-1">{{ $equipo->observaciones }}</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Historial de Mantenimientos --}}
            @if($equipo->mantenimientos->count())
            <div class="intro-y box mt-5 p-5">
                <div class="mb-3 flex items-center">
                    <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="Tool" />
                    <span class="text-base font-medium">Historial de Mantenimientos ({{ $equipo->mantenimientos->count() }})</span>
                </div>
                <x-base.table class="border-separate border-spacing-y-[10px]">
                    <x-base.table.thead>
                        <x-base.table.tr>
                            <x-base.table.th class="border-b-0">Código</x-base.table.th>
                            <x-base.table.th class="border-b-0">Tipo</x-base.table.th>
                            <x-base.table.th class="border-b-0">Fecha</x-base.table.th>
                            <x-base.table.th class="border-b-0">Estado</x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                    <x-base.table.tbody>
                        @foreach($equipo->mantenimientos->take(10) as $mant)
                        <x-base.table.tr>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">
                                <a href="{{ route('gestion.mantenimientos.show', $mant) }}" class="text-primary">{{ $mant->codigo }}</a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">{!! $mant->tipo_mantenimiento_badge !!}</x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">{{ $mant->fecha_programada?->format('d/m/Y') ?? '—' }}</x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">{!! $mant->estado_badge !!}</x-base.table.td>
                        </x-base.table.tr>
                        @endforeach
                    </x-base.table.tbody>
                </x-base.table>
            </div>
            @endif
        </div>
    </div>
@endsection
