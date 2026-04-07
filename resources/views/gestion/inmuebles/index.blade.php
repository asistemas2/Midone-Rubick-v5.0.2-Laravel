@extends('../layouts/' . $layout)

@section('subhead')
    <title>Inmuebles - Gestión ZFP</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Gestión de Inmuebles</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('gestion.inmuebles.create') }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Plus" />
                    Nuevo Inmueble
                </x-base.button>
            </a>
            <div class="mx-auto hidden text-slate-500 md:block">
                Mostrando {{ $inmuebles->firstItem() ?? 0 }} a {{ $inmuebles->lastItem() ?? 0 }} de {{ $inmuebles->total() }} registros
            </div>
            <div class="mt-3 w-full sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
                <form action="{{ route('gestion.inmuebles.index') }}" method="GET" class="flex gap-2">
                    <x-base.form-select class="!box w-32" name="estado">
                        <option value="">Estado</option>
                        <option value="operativo" {{ request('estado') == 'operativo' ? 'selected' : '' }}>Operativo</option>
                        <option value="mantenimiento" {{ request('estado') == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                        <option value="fuera_servicio" {{ request('estado') == 'fuera_servicio' ? 'selected' : '' }}>Fuera Servicio</option>
                    </x-base.form-select>
                    <x-base.form-select class="!box w-36" name="bloque_id">
                        <option value="">Bloque</option>
                        @foreach($bloques as $bloque)
                            <option value="{{ $bloque->id }}" {{ request('bloque_id') == $bloque->id ? 'selected' : '' }}>{{ $bloque->nombre }}</option>
                        @endforeach
                    </x-base.form-select>
                    <div class="relative w-56 text-slate-500">
                        <x-base.form-input class="!box w-56 pr-10" name="buscar" type="text" value="{{ request('buscar') }}" placeholder="Buscar..." />
                        <x-base.lucide class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4" icon="Search" />
                    </div>
                </form>
            </div>
        </div>

        {{-- Mensajes Flash --}}
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

        {{-- Tabla --}}
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">CÓDIGO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">NOMBRE</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">BLOQUE</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">TIPO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ÁREA (m²)</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ESTADO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ACCIONES</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @forelse ($inmuebles as $inmueble)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <span class="rounded bg-slate-100 px-2 py-1 text-xs font-medium dark:bg-darkmode-400">{{ $inmueble->codigo }}</span>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="whitespace-nowrap font-medium" href="{{ route('gestion.inmuebles.show', $inmueble) }}">{{ Str::limit($inmueble->nombre, 40) }}</a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $inmueble->bloque?->nombre ?? '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $inmueble->tipoInmueble?->nombre ?? '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $inmueble->area_m2 ? number_format($inmueble->area_m2, 2) : '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {!! $inmueble->estado_badge !!}
                            </x-base.table.td>
                            <x-base.table.td class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center">
                                    <a class="mr-3 flex items-center" href="{{ route('gestion.inmuebles.edit', $inmueble) }}">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" /> Editar
                                    </a>
                                    <a class="flex items-center text-danger" data-tw-toggle="modal" data-tw-target="#delete-modal-{{ $inmueble->id }}" href="javascript:;">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" /> Eliminar
                                    </a>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @empty
                        <x-base.table.tr>
                            <x-base.table.td colspan="7" class="border-b-0 bg-white text-center py-8 text-slate-500 dark:bg-darkmode-600">
                                <x-base.lucide class="mx-auto h-8 w-8 text-slate-300" icon="Building2" />
                                <div class="mt-2">No se encontraron inmuebles.</div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforelse
                </x-base.table.tbody>
            </x-base.table>
        </div>

        @if ($inmuebles->hasPages())
            <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
                {{ $inmuebles->links() }}
            </div>
        @endif
    </div>

    {{-- Modales de eliminación --}}
    @foreach ($inmuebles as $inmueble)
        <x-base.dialog id="delete-modal-{{ $inmueble->id }}">
            <x-base.dialog.panel>
                <div class="p-5 text-center">
                    <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                    <div class="mt-5 text-3xl">¿Está seguro?</div>
                    <div class="mt-2 text-slate-500">
                        ¿Desea eliminar el inmueble <strong>{{ $inmueble->nombre }}</strong>?
                        <br />Esta acción se puede revertir.
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">Cancelar</x-base.button>
                    <form action="{{ route('gestion.inmuebles.destroy', $inmueble) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-base.button class="w-24" type="submit" variant="danger">Eliminar</x-base.button>
                    </form>
                </div>
            </x-base.dialog.panel>
        </x-base.dialog>
    @endforeach
@endsection
