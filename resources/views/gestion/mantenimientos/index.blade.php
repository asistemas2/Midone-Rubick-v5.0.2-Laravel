@extends('../layouts/' . $layout)

@section('subhead')
    <title>Mantenimientos - Gestión ZFP</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Gestión de Mantenimientos</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('gestion.mantenimientos.create') }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Plus" /> Nuevo Mantenimiento
                </x-base.button>
            </a>
            <div class="mx-auto hidden text-slate-500 md:block">
                Mostrando {{ $mantenimientos->firstItem() ?? 0 }} a {{ $mantenimientos->lastItem() ?? 0 }} de {{ $mantenimientos->total() }} registros
            </div>
            <div class="mt-3 w-full sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
                <form action="{{ route('gestion.mantenimientos.index') }}" method="GET" class="flex gap-2">
                    <x-base.form-select class="!box w-28" name="estado">
                        <option value="">Estado</option>
                        <option value="programado" {{ request('estado') == 'programado' ? 'selected' : '' }}>Programado</option>
                        <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                        <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                        <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </x-base.form-select>
                    <x-base.form-select class="!box w-28" name="tipo_activo">
                        <option value="">Activo</option>
                        <option value="inmueble" {{ request('tipo_activo') == 'inmueble' ? 'selected' : '' }}>Inmueble</option>
                        <option value="equipo" {{ request('tipo_activo') == 'equipo' ? 'selected' : '' }}>Equipo</option>
                    </x-base.form-select>
                    <x-base.form-select class="!box w-28" name="tipo_mantenimiento">
                        <option value="">Tipo</option>
                        <option value="preventivo" {{ request('tipo_mantenimiento') == 'preventivo' ? 'selected' : '' }}>Preventivo</option>
                        <option value="correctivo" {{ request('tipo_mantenimiento') == 'correctivo' ? 'selected' : '' }}>Correctivo</option>
                        <option value="predictivo" {{ request('tipo_mantenimiento') == 'predictivo' ? 'selected' : '' }}>Predictivo</option>
                    </x-base.form-select>
                    <div class="relative w-48 text-slate-500">
                        <x-base.form-input class="!box w-48 pr-10" name="buscar" type="text" value="{{ request('buscar') }}" placeholder="Buscar..." />
                        <x-base.lucide class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4" icon="Search" />
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="intro-y col-span-12"><div class="rounded-md bg-success/20 px-5 py-3 text-success"><x-base.lucide class="mr-2 inline h-4 w-4" icon="CheckCircle" /> {{ session('success') }}</div></div>
        @endif
        @if (session('error'))
            <div class="intro-y col-span-12"><div class="rounded-md bg-danger/20 px-5 py-3 text-danger"><x-base.lucide class="mr-2 inline h-4 w-4" icon="XCircle" /> {{ session('error') }}</div></div>
        @endif

        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">CÓDIGO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">TIPO ACTIVO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">DESCRIPCIÓN</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">TIPO MANT.</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">FECHA PROG.</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ESTADO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ACCIONES</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @forelse ($mantenimientos as $mant)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <span class="rounded bg-slate-100 px-2 py-1 text-xs font-medium dark:bg-darkmode-400">{{ $mant->codigo }}</span>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <span class="rounded-full px-2 py-1 text-xs {{ $mant->tipo_activo === 'inmueble' ? 'bg-primary/20 text-primary' : 'bg-warning/20 text-warning' }}">{{ ucfirst($mant->tipo_activo) }}</span>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="font-medium" href="{{ route('gestion.mantenimientos.show', $mant) }}">{{ Str::limit($mant->descripcion, 50) }}</a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {!! $mant->tipo_mantenimiento_badge !!}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $mant->fecha_programada?->format('d/m/Y') ?? '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {!! $mant->estado_badge !!}
                            </x-base.table.td>
                            <x-base.table.td class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center">
                                    <a class="mr-3 flex items-center" href="{{ route('gestion.mantenimientos.edit', $mant) }}">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" /> Editar
                                    </a>
                                    <a class="flex items-center text-danger" data-tw-toggle="modal" data-tw-target="#delete-modal-{{ $mant->id }}" href="javascript:;">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" /> Eliminar
                                    </a>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @empty
                        <x-base.table.tr>
                            <x-base.table.td colspan="7" class="border-b-0 bg-white text-center py-8 text-slate-500 dark:bg-darkmode-600">
                                <x-base.lucide class="mx-auto h-8 w-8 text-slate-300" icon="Tool" />
                                <div class="mt-2">No se encontraron mantenimientos.</div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforelse
                </x-base.table.tbody>
            </x-base.table>
        </div>

        @if ($mantenimientos->hasPages())
            <div class="intro-y col-span-12 flex flex-wrap items-center">{{ $mantenimientos->links() }}</div>
        @endif
    </div>

    @foreach ($mantenimientos as $mant)
        <x-base.dialog id="delete-modal-{{ $mant->id }}">
            <x-base.dialog.panel>
                <div class="p-5 text-center">
                    <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                    <div class="mt-5 text-3xl">¿Está seguro?</div>
                    <div class="mt-2 text-slate-500">¿Desea eliminar el mantenimiento <strong>{{ $mant->codigo }}</strong>?</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">Cancelar</x-base.button>
                    <form action="{{ route('gestion.mantenimientos.destroy', $mant) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <x-base.button class="w-24" type="submit" variant="danger">Eliminar</x-base.button>
                    </form>
                </div>
            </x-base.dialog.panel>
        </x-base.dialog>
    @endforeach
@endsection
