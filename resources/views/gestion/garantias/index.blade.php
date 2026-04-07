@extends('../layouts/' . $layout)

@section('subhead')
    <title>Garantías - Gestión ZFP</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Gestión de Garantías</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('gestion.garantias.create') }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Plus" /> Nueva Garantía
                </x-base.button>
            </a>
            <div class="mx-auto hidden text-slate-500 md:block">
                Mostrando {{ $garantias->firstItem() ?? 0 }} a {{ $garantias->lastItem() ?? 0 }} de {{ $garantias->total() }} registros
            </div>
            <div class="mt-3 w-full sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
                <form action="{{ route('gestion.garantias.index') }}" method="GET" class="flex gap-2">
                    <x-base.form-select class="!box w-32" name="estado">
                        <option value="">Estado</option>
                        <option value="activa" {{ request('estado') == 'activa' ? 'selected' : '' }}>Activa</option>
                        <option value="vencida" {{ request('estado') == 'vencida' ? 'selected' : '' }}>Vencida</option>
                        <option value="en_tramite" {{ request('estado') == 'en_tramite' ? 'selected' : '' }}>En Trámite</option>
                    </x-base.form-select>
                    <x-base.form-select class="!box w-32" name="vigencia">
                        <option value="">Vigencia</option>
                        <option value="vigente" {{ request('vigencia') == 'vigente' ? 'selected' : '' }}>Vigente</option>
                        <option value="por_vencer" {{ request('vigencia') == 'por_vencer' ? 'selected' : '' }}>Por Vencer (30d)</option>
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
                        <x-base.table.th class="whitespace-nowrap border-b-0">CÓDIGO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">MANTENIMIENTO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">PROVEEDOR</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">VIGENCIA</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ESTADO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">MONTO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ACCIONES</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @forelse ($garantias as $garantia)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <span class="rounded bg-slate-100 px-2 py-1 text-xs font-medium dark:bg-darkmode-400">{{ $garantia->codigo }}</span>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $garantia->mantenimiento?->codigo ?? '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="font-medium" href="{{ route('gestion.garantias.show', $garantia) }}">{{ $garantia->proveedor ?? '—' }}</a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <div class="text-xs">
                                    {{ $garantia->fecha_inicio?->format('d/m/Y') ?? '—' }}
                                    <br>{{ $garantia->fecha_fin?->format('d/m/Y') ?? '—' }}
                                </div>
                                @if($garantia->dias_restantes !== null)
                                    <div class="text-xs mt-1 {{ $garantia->dias_restantes > 30 ? 'text-success' : ($garantia->dias_restantes > 0 ? 'text-warning' : 'text-danger') }}">
                                        {{ $garantia->dias_restantes > 0 ? $garantia->dias_restantes . ' días' : 'Vencida' }}
                                    </div>
                                @endif
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {!! $garantia->estado_badge !!}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $garantia->monto ? '$ ' . number_format($garantia->monto, 2) : '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center">
                                    <a class="mr-3 flex items-center" href="{{ route('gestion.garantias.edit', $garantia) }}">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" /> Editar
                                    </a>
                                    <a class="flex items-center text-danger" data-tw-toggle="modal" data-tw-target="#delete-modal-{{ $garantia->id }}" href="javascript:;">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" /> Eliminar
                                    </a>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @empty
                        <x-base.table.tr>
                            <x-base.table.td colspan="7" class="border-b-0 bg-white text-center py-8 text-slate-500 dark:bg-darkmode-600">
                                <x-base.lucide class="mx-auto h-8 w-8 text-slate-300" icon="ShieldCheck" />
                                <div class="mt-2">No se encontraron garantías.</div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforelse
                </x-base.table.tbody>
            </x-base.table>
        </div>

        @if ($garantias->hasPages())
            <div class="intro-y col-span-12 flex flex-wrap items-center">{{ $garantias->links() }}</div>
        @endif
    </div>

    @foreach ($garantias as $garantia)
        <x-base.dialog id="delete-modal-{{ $garantia->id }}">
            <x-base.dialog.panel>
                <div class="p-5 text-center">
                    <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                    <div class="mt-5 text-3xl">¿Está seguro?</div>
                    <div class="mt-2 text-slate-500">¿Desea eliminar la garantía <strong>{{ $garantia->codigo }}</strong>?</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">Cancelar</x-base.button>
                    <form action="{{ route('gestion.garantias.destroy', $garantia) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <x-base.button class="w-24" type="submit" variant="danger">Eliminar</x-base.button>
                    </form>
                </div>
            </x-base.dialog.panel>
        </x-base.dialog>
    @endforeach
@endsection
