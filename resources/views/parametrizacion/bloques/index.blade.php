@extends('../layouts/' . $layout)

@section('subhead')
    <title>Bloques - Parametrización ZFP</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Gestión de Bloques</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('parametrizacion.bloques.create') }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Plus" />
                    Nuevo Bloque
                </x-base.button>
            </a>
            <div class="mx-auto hidden text-slate-500 md:block">
                Mostrando {{ $bloques->firstItem() ?? 0 }} a {{ $bloques->lastItem() ?? 0 }} de {{ $bloques->total() }} registros
            </div>
            <div class="mt-3 w-full sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
                <form action="{{ route('parametrizacion.bloques.index') }}" method="GET">
                    <div class="relative w-56 text-slate-500">
                        <x-base.form-input
                            class="!box w-56 pr-10"
                            name="buscar"
                            type="text"
                            value="{{ request('buscar') }}"
                            placeholder="Buscar..."
                        />
                        <x-base.lucide class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4" icon="Search" />
                    </div>
                </form>
            </div>
        </div>

        {{-- Mensajes Flash --}}
        @if (session('success'))
            <div class="intro-y col-span-12">
                <div class="rounded-md bg-success/20 px-5 py-3 text-success">
                    <x-base.lucide class="mr-2 inline h-4 w-4" icon="CheckCircle" />
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="intro-y col-span-12">
                <div class="rounded-md bg-danger/20 px-5 py-3 text-danger">
                    <x-base.lucide class="mr-2 inline h-4 w-4" icon="XCircle" />
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Tabla de datos --}}
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">NOMBRE</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">CÓDIGO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ÁREA (m²)</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ESTADO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ACCIONES</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @forelse ($bloques as $bloque)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="whitespace-nowrap font-medium" href="{{ route('parametrizacion.bloques.show', $bloque) }}">
                                    {{ $bloque->nombre }}
                                </a>
                                @if($bloque->descripcion)
                                    <div class="mt-0.5 whitespace-nowrap text-xs text-slate-500">{{ Str::limit($bloque->descripcion, 50) }}</div>
                                @endif
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <span class="rounded bg-slate-100 px-2 py-1 text-xs font-medium dark:bg-darkmode-400">{{ $bloque->codigo }}</span>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $bloque->area_m2 ? number_format($bloque->area_m2, 2) : '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="w-40 border-b-0 bg-white shadow-[20px_3px_20px_#0000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <div @class(['flex items-center justify-center', 'text-success' => $bloque->activo, 'text-danger' => !$bloque->activo])>
                                    <x-base.lucide class="mr-2 h-4 w-4" icon="CheckSquare" />
                                    {{ $bloque->activo ? 'Activo' : 'Inactivo' }}
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center">
                                    <a class="mr-3 flex items-center" href="{{ route('parametrizacion.bloques.edit', $bloque) }}">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" /> Editar
                                    </a>
                                    <a class="flex items-center text-danger" data-tw-toggle="modal" data-tw-target="#delete-modal-{{ $bloque->id }}" href="javascript:;">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" /> Eliminar
                                    </a>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @empty
                        <x-base.table.tr>
                            <x-base.table.td colspan="5" class="border-b-0 bg-white text-center py-8 text-slate-500 dark:bg-darkmode-600">
                                <x-base.lucide class="mx-auto h-8 w-8 text-slate-300" icon="Database" />
                                <div class="mt-2">No se encontraron bloques.</div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforelse
                </x-base.table.tbody>
            </x-base.table>
        </div>

        {{-- Paginación --}}
        @if ($bloques->hasPages())
            <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
                {{ $bloques->links() }}
            </div>
        @endif
    </div>

    {{-- Modales de eliminación --}}
    @foreach ($bloques as $bloque)
        <x-base.dialog id="delete-modal-{{ $bloque->id }}">
            <x-base.dialog.panel>
                <div class="p-5 text-center">
                    <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                    <div class="mt-5 text-3xl">¿Está seguro?</div>
                    <div class="mt-2 text-slate-500">
                        ¿Desea eliminar el bloque <strong>{{ $bloque->nombre }}</strong>?
                        <br />Esta acción se puede revertir.
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">Cancelar</x-base.button>
                    <form action="{{ route('parametrizacion.bloques.destroy', $bloque) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-base.button class="w-24" type="submit" variant="danger">Eliminar</x-base.button>
                    </form>
                </div>
            </x-base.dialog.panel>
        </x-base.dialog>
    @endforeach
@endsection
