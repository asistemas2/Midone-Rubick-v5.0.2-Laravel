@extends('../layouts/' . $layout)

@section('subhead')
    <title>Asignación de Equipos - Gestión ZFP</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Asignación de Equipos a Inmuebles</h2>

    {{-- Tarjetas de Estadísticas --}}
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="relative zoom-in before:content-[''] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70">
                <div class="box p-5">
                    <div class="flex">
                        <x-base.lucide class="h-[28px] w-[28px] text-primary" icon="Package" />
                        <div class="ml-auto">
                            <x-base.tippy as="div" class="cursor-pointer rounded-full bg-primary/10 px-1.5 py-px text-xs font-medium text-primary" content="Total de equipos registrados">
                                Total
                            </x-base.tippy>
                        </div>
                    </div>
                    <div class="mt-6 text-3xl font-medium leading-8">{{ number_format($totalEquipos) }}</div>
                    <div class="mt-1 text-base text-slate-500">Total Equipos</div>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="relative zoom-in before:content-[''] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70">
                <div class="box p-5">
                    <div class="flex">
                        <x-base.lucide class="h-[28px] w-[28px] text-success" icon="link" />
                        <div class="ml-auto">
                            <x-base.tippy as="div" class="cursor-pointer rounded-full bg-success/10 px-1.5 py-px text-xs font-medium text-success" content="Equipos con inmueble asignado">
                                Activos
                            </x-base.tippy>
                        </div>
                    </div>
                    <div class="mt-6 text-3xl font-medium leading-8">{{ number_format($asignados) }}</div>
                    <div class="mt-1 text-base text-slate-500">Equipos Asignados</div>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="relative zoom-in before:content-[''] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70">
                <div class="box p-5">
                    <div class="flex">
                        <x-base.lucide class="h-[28px] w-[28px] text-warning" icon="Unlink" />
                        <div class="ml-auto">
                            <x-base.tippy as="div" class="cursor-pointer rounded-full bg-warning/10 px-1.5 py-px text-xs font-medium text-warning" content="Equipos sin inmueble asignado">
                                Pendientes
                            </x-base.tippy>
                        </div>
                    </div>
                    <div class="mt-6 text-3xl font-medium leading-8">{{ number_format($sinAsignar) }}</div>
                    <div class="mt-1 text-base text-slate-500">Sin Asignar</div>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
            <div class="relative zoom-in before:content-[''] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70">
                <div class="box p-5">
                    <div class="flex">
                        <x-base.lucide class="h-[28px] w-[28px] text-info" icon="BarChart3" />
                        <div class="ml-auto">
                            <x-base.tippy as="div" class="cursor-pointer rounded-full bg-info/10 px-1.5 py-px text-xs font-medium text-info" content="Porcentaje de equipos asignados">
                                %
                            </x-base.tippy>
                        </div>
                    </div>
                    <div class="mt-6 text-3xl font-medium leading-8">{{ $porcentajeAsignacion }}%</div>
                    <div class="mt-1 text-base text-slate-500">% Asignación</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros y Tabla --}}
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('gestion.asignaciones.create') }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Link" /> Asignar Equipo
                </x-base.button>
            </a>
            <div class="mx-auto hidden text-slate-500 md:block">
                Mostrando {{ $equipos->firstItem() ?? 0 }} a {{ $equipos->lastItem() ?? 0 }} de {{ $equipos->total() }} registros
            </div>
            <div class="mt-3 w-full sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
                <form action="{{ route('gestion.asignaciones.index') }}" method="GET" class="flex flex-wrap gap-2">
                    <x-base.form-select class="!box w-40" name="inmueble_id">
                        <option value="">Inmueble</option>
                        @foreach($inmuebles as $inm)
                            <option value="{{ $inm->id }}" {{ request('inmueble_id') == $inm->id ? 'selected' : '' }}>{{ Str::limit($inm->nombre, 25) }}</option>
                        @endforeach
                    </x-base.form-select>
                    <x-base.form-select class="!box w-32" name="tipo_equipo_id">
                        <option value="">Tipo Equipo</option>
                        @foreach($tiposEquipo as $tipo)
                            <option value="{{ $tipo->id }}" {{ request('tipo_equipo_id') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                        @endforeach
                    </x-base.form-select>
                    <x-base.form-select class="!box w-32" name="estado_asignacion">
                        <option value="">Asignación</option>
                        <option value="asignado" {{ request('estado_asignacion') === 'asignado' ? 'selected' : '' }}>Asignado</option>
                        <option value="sin_asignar" {{ request('estado_asignacion') === 'sin_asignar' ? 'selected' : '' }}>Sin Asignar</option>
                    </x-base.form-select>
                    <div class="relative w-56 text-slate-500">
                        <x-base.form-input class="!box w-56 pr-10" name="buscar" type="text" value="{{ request('buscar') }}" placeholder="Buscar equipo..." />
                        <x-base.lucide class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4" icon="Search" />
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="intro-y col-span-12">
                <div class="rounded-md bg-success/20 px-5 py-3 text-success">
                    <x-base.lucide class="mr-2 inline h-4 w-4" icon="CheckCircle" /> {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="intro-y col-span-12">
                <div class="rounded-md bg-danger/20 px-5 py-3 text-danger">
                    <x-base.lucide class="mr-2 inline h-4 w-4" icon="XCircle" /> {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">CÓDIGO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">EQUIPO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">TIPO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">MARCA</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ESTADO ASIGNACIÓN</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">INMUEBLE ASIGNADO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ACCIONES</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @forelse ($equipos as $equipo)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <span class="rounded bg-slate-100 px-2 py-1 text-xs font-medium dark:bg-darkmode-400">{{ $equipo->codigo }}</span>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="whitespace-nowrap font-medium" href="{{ route('gestion.asignaciones.show', $equipo) }}">{{ Str::limit($equipo->nombre, 35) }}</a>
                                <div class="mt-0.5 whitespace-nowrap text-xs text-slate-500">{{ $equipo->categoriaEquipo?->nombre ?? '' }}</div>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $equipo->tipoEquipo?->nombre ?? '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $equipo->marca?->nombre ?? '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                @if($equipo->inmueble_id)
                                    <span class="rounded-full bg-success/20 px-2 py-1 text-xs text-success">
                                        <x-base.lucide class="mr-1 inline h-3 w-3" icon="Check" /> Asignado
                                    </span>
                                @else
                                    <span class="rounded-full bg-warning/20 px-2 py-1 text-xs text-warning">
                                        <x-base.lucide class="mr-1 inline h-3 w-3" icon="AlertCircle" /> Sin Asignar
                                    </span>
                                @endif
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                @if($equipo->inmueble)
                                    <div class="font-medium">{{ Str::limit($equipo->inmueble->nombre, 30) }}</div>
                                    <div class="mt-0.5 text-xs text-slate-500">{{ $equipo->inmueble->bloque?->nombre ?? '' }}</div>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </x-base.table.td>
                            <x-base.table.td class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center">
                                    @if($equipo->inmueble_id)
                                        <a class="mr-3 flex items-center text-primary" href="{{ route('gestion.asignaciones.edit', $equipo) }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="ArrowRightLeft" /> Reasignar
                                        </a>
                                        <a class="flex items-center text-danger" data-tw-toggle="modal" data-tw-target="#desasignar-modal-{{ $equipo->id }}" href="javascript:;">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="Unlink" /> Desasignar
                                        </a>
                                    @else
                                        <a class="flex items-center text-success" href="{{ route('gestion.asignaciones.create', ['equipo_id' => $equipo->id]) }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="Link" /> Asignar
                                        </a>
                                    @endif
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @empty
                        <x-base.table.tr>
                            <x-base.table.td colspan="7" class="border-b-0 bg-white text-center py-8 text-slate-500 dark:bg-darkmode-600">
                                <x-base.lucide class="mx-auto h-8 w-8 text-slate-300" icon="Link" />
                                <div class="mt-2">No se encontraron equipos.</div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforelse
                </x-base.table.tbody>
            </x-base.table>
        </div>

        @if ($equipos->hasPages())
            <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
                {{ $equipos->links() }}
            </div>
        @endif
    </div>

    {{-- Modales de Desasignación --}}
    @foreach ($equipos as $equipo)
        @if($equipo->inmueble_id)
        <x-base.dialog id="desasignar-modal-{{ $equipo->id }}">
            <x-base.dialog.panel>
                <div class="p-5 text-center">
                    <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-warning" icon="Unlink" />
                    <div class="mt-5 text-3xl">¿Desasignar equipo?</div>
                    <div class="mt-2 text-slate-500">
                        ¿Desea desasignar el equipo <strong>{{ $equipo->nombre }}</strong>
                        del inmueble <strong>{{ $equipo->inmueble?->nombre }}</strong>?
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">Cancelar</x-base.button>
                    <form action="{{ route('gestion.asignaciones.destroy', $equipo) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <x-base.button class="w-28" type="submit" variant="warning">Desasignar</x-base.button>
                    </form>
                </div>
            </x-base.dialog.panel>
        </x-base.dialog>
        @endif
    @endforeach
@endsection
