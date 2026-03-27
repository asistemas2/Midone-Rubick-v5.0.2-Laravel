@extends('../layouts/' . $layout)

@section('subhead')
    <title>Categorías de Equipo - Parametrización ZFP</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Gestión de Categorías de Equipo</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('parametrizacion.categorias_equipo.create') }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Plus" /> Nueva Categoría
                </x-base.button>
            </a>
            <div class="mx-auto hidden text-slate-500 md:block">
                Mostrando {{ $categorias->firstItem() ?? 0 }} a {{ $categorias->lastItem() ?? 0 }} de {{ $categorias->total() }} registros
            </div>
            <div class="mt-3 flex w-full gap-2 sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
                <form action="{{ route('parametrizacion.categorias_equipo.index') }}" method="GET" class="flex gap-2">
                    <x-base.form-select class="!box w-44" name="tipo_equipo_id" onchange="this.form.submit()">
                        <option value="">Todos los tipos</option>
                        @foreach ($tiposEquipo as $tipo)
                            <option value="{{ $tipo->id }}" {{ request('tipo_equipo_id') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                        @endforeach
                    </x-base.form-select>
                    <div class="relative w-56 text-slate-500">
                        <x-base.form-input class="!box w-56 pr-10" name="buscar" type="text" value="{{ request('buscar') }}" placeholder="Buscar..." />
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
                        <x-base.table.th class="whitespace-nowrap border-b-0">NOMBRE</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">TIPO DE EQUIPO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">DESCRIPCIÓN</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ESTADO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ACCIONES</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @forelse ($categorias as $categoria)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="whitespace-nowrap font-medium" href="{{ route('parametrizacion.categorias_equipo.show', $categoria) }}">{{ $categoria->nombre }}</a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                @if($categoria->tipoEquipo)
                                    <span class="rounded bg-primary/10 px-2 py-1 text-xs font-medium text-primary">{{ $categoria->tipoEquipo->nombre }}</span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ Str::limit($categoria->descripcion, 50) ?? '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="w-40 border-b-0 bg-white shadow-[20px_3px_20px_#0000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <div @class(['flex items-center justify-center', 'text-success' => $categoria->activo, 'text-danger' => !$categoria->activo])>
                                    <x-base.lucide class="mr-2 h-4 w-4" icon="CheckSquare" /> {{ $categoria->activo ? 'Activo' : 'Inactivo' }}
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center">
                                    <a class="mr-3 flex items-center" href="{{ route('parametrizacion.categorias_equipo.edit', $categoria) }}"><x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" /> Editar</a>
                                    <a class="flex items-center text-danger" data-tw-toggle="modal" data-tw-target="#delete-modal-{{ $categoria->id }}" href="javascript:;"><x-base.lucide class="mr-1 h-4 w-4" icon="Trash" /> Eliminar</a>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @empty
                        <x-base.table.tr>
                            <x-base.table.td colspan="5" class="border-b-0 bg-white text-center py-8 text-slate-500 dark:bg-darkmode-600">
                                <x-base.lucide class="mx-auto h-8 w-8 text-slate-300" icon="Database" />
                                <div class="mt-2">No se encontraron categorías de equipo.</div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforelse
                </x-base.table.tbody>
            </x-base.table>
        </div>

        @if ($categorias->hasPages())
            <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">{{ $categorias->links() }}</div>
        @endif
    </div>

    @foreach ($categorias as $categoria)
        <x-base.dialog id="delete-modal-{{ $categoria->id }}">
            <x-base.dialog.panel>
                <div class="p-5 text-center">
                    <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                    <div class="mt-5 text-3xl">¿Está seguro?</div>
                    <div class="mt-2 text-slate-500">¿Desea eliminar <strong>{{ $categoria->nombre }}</strong>?</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">Cancelar</x-base.button>
                    <form action="{{ route('parametrizacion.categorias_equipo.destroy', $categoria) }}" method="POST" class="inline">@csrf @method('DELETE')
                        <x-base.button class="w-24" type="submit" variant="danger">Eliminar</x-base.button>
                    </form>
                </div>
            </x-base.dialog.panel>
        </x-base.dialog>
    @endforeach
@endsection
