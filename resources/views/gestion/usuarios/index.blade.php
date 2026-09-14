@extends('../layouts/' . $layout)

@section('subhead')
    <title>Gestión de Usuarios - ZFP</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">Gestión de Usuarios</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('gestion.usuarios.create') }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="UserPlus" />
                    Nuevo Usuario
                </x-base.button>
            </a>
            <div class="mx-auto hidden text-slate-500 md:block">
                Mostrando {{ $users->firstItem() ?? 0 }} a {{ $users->lastItem() ?? 0 }} de {{ $users->total() }} registros
            </div>
            <div class="mt-3 w-full sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
                <form action="{{ route('gestion.usuarios.index') }}" method="GET">
                    <div class="relative w-56 text-slate-500">
                        <x-base.form-input class="!box w-56 pr-10" name="buscar" type="text" value="{{ request('buscar') }}" placeholder="Buscar..." />
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
                        <x-base.table.th class="whitespace-nowrap border-b-0">NOMBRE</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">EMAIL</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">CARGO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">ROLES</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ESTADO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ACCIONES</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @forelse ($users as $user)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <div class="flex items-center">
                                    @if($user->avatar)
                                        <img class="h-8 w-8 rounded-full" src="{{ $user->avatar }}" alt="Avatar">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 text-xs font-bold">
                                            {{ strtoupper(substr($user->full_name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <span class="ml-2 font-medium">{{ $user->full_name }}</span>
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $user->email }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $user->position ?? '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                @foreach($user->roles as $role)
                                    <span class="rounded bg-primary/10 px-2 py-1 text-xs font-medium text-primary">{{ $role->name }}</span>
                                @endforeach
                            </x-base.table.td>
                            <x-base.table.td class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <div @class(['flex items-center justify-center', 'text-success' => $user->active, 'text-danger' => !$user->active])>
                                    <x-base.lucide class="mr-2 h-4 w-4" icon="CheckSquare" />
                                    {{ $user->active ? 'Activo' : 'Inactivo' }}
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center">
                                    <a class="mr-3 flex items-center" href="{{ route('gestion.usuarios.edit', $user) }}">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Edit" /> Editar
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <a class="flex items-center text-danger" data-tw-toggle="modal" data-tw-target="#delete-modal-{{ $user->id }}" href="javascript:;">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" /> Eliminar
                                        </a>
                                    @endif
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @empty
                        <x-base.table.tr>
                            <x-base.table.td colspan="6" class="border-b-0 bg-white text-center py-8 text-slate-500 dark:bg-darkmode-600">
                                <x-base.lucide class="mx-auto h-8 w-8 text-slate-300" icon="Users" />
                                <div class="mt-2">No se encontraron usuarios.</div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforelse
                </x-base.table.tbody>
            </x-base.table>
        </div>

        @if ($users->hasPages())
            <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    @foreach ($users as $user)
        <x-base.dialog id="delete-modal-{{ $user->id }}">
            <x-base.dialog.panel>
                <div class="p-5 text-center">
                    <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                    <div class="mt-5 text-3xl">¿Está seguro?</div>
                    <div class="mt-2 text-slate-500">
                        ¿Desea eliminar al usuario <strong>{{ $user->full_name }}</strong>?
                        <br />Esta acción no se puede deshacer.
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">Cancelar</x-base.button>
                    <form action="{{ route('gestion.usuarios.destroy', $user) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <x-base.button class="w-24" type="submit" variant="danger">Eliminar</x-base.button>
                    </form>
                </div>
            </x-base.dialog.panel>
        </x-base.dialog>
    @endforeach
@endsection