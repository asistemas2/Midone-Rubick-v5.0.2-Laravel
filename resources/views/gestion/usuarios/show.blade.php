@extends('../layouts/' . $layout)

@section('subhead')
    <title>Detalle Usuario - ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Detalle de Usuario</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('gestion.usuarios.index') }}" class="hover:text-primary">Usuarios</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>{{ $user->full_name }}</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <div class="flex items-center border-b border-slate-200/60 pb-5 dark:border-darkmode-400">
                    <div class="flex items-center">
                        @if($user->avatar)
                            <img class="h-12 w-12 rounded-full" src="{{ $user->avatar }}" alt="Avatar">
                        @else
                            <div class="h-12 w-12 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 text-lg font-bold">
                                {{ strtoupper(substr($user->full_name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="ml-3">
                            <div class="text-base font-medium">{{ $user->full_name }}</div>
                            <div class="text-sm text-slate-500">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <span @class(['rounded-full px-3 py-1 text-xs font-medium text-white', 'bg-success' => $user->active, 'bg-danger' => !$user->active])>
                            {{ $user->active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
                <div class="mt-5 space-y-4">
                    <div class="flex items-center">
                        <span class="w-36 text-slate-500">Cargo:</span>
                        <span class="font-medium">{{ $user->position ?? '—' }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-36 text-slate-500">Género:</span>
                        <span class="font-medium">{{ $user->gender ?? '—' }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-36 text-slate-500">Proveedor:</span>
                        <span class="font-medium">{{ $user->provider ?? 'Local' }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-36 text-slate-500">Roles:</span>
                        <div class="flex flex-wrap gap-1">
                            @foreach($user->roles as $role)
                                <span class="rounded bg-primary/10 px-2 py-1 text-xs font-medium text-primary">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="w-36 text-slate-500">Creado:</span>
                        <span class="font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-36 text-slate-500">Actualizado:</span>
                        <span class="font-medium">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div class="mt-5 flex justify-end border-t border-slate-200/60 pt-5 dark:border-darkmode-400">
                    <a href="{{ route('gestion.usuarios.index') }}">
                        <x-base.button class="mr-2 w-24" type="button" variant="outline-secondary">Volver</x-base.button>
                    </a>
                    <a href="{{ route('gestion.usuarios.edit', $user) }}">
                        <x-base.button class="w-24" type="button" variant="primary">Editar</x-base.button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection