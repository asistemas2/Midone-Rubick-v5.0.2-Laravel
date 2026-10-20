@extends('../layouts/' . $layout)

@section('subhead')
    <title>Mi Perfil - ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Mi Perfil</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        @include('gestion.usuarios.partials._perfil-menu')

        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            @if (session('success'))
                <div class="intro-y mt-5 rounded-md bg-success/20 px-5 py-3 text-success">
                    <x-base.lucide class="mr-2 inline h-4 w-4" icon="CheckCircle" /> {{ session('success') }}
                </div>
            @endif

            {{-- Encabezado (basado en el "Profile Info" de profile-overview) --}}
            <div class="intro-y box mt-5 px-5 pt-5">
                <div class="-mx-5 flex flex-col border-b border-slate-200/60 pb-5 dark:border-darkmode-400 lg:flex-row">
                    <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
                        <div class="image-fit relative h-20 w-20 flex-none sm:h-24 sm:w-24 lg:h-32 lg:w-32">
                            <img
                                class="rounded-full"
                                src="{{ $user->avatar ?? Vite::asset('resources/images/default-avatar.png') }}"
                                alt="{{ $user->full_name }}"
                            />
                        </div>
                        <div class="ml-5">
                            <div class="w-24 truncate text-lg font-medium sm:w-40 sm:whitespace-normal">{{ $user->full_name }}</div>
                            <div class="text-slate-500">{{ $user->position ?? 'Sin cargo' }}</div>
                        </div>
                    </div>
                    <div class="mt-6 flex-1 border-l border-r border-t border-slate-200/60 px-5 pt-5 dark:border-darkmode-400 lg:mt-0 lg:border-t-0 lg:pt-0">
                        <div class="text-center font-medium lg:mt-3 lg:text-left">Datos de Contacto</div>
                        <div class="mt-4 flex flex-col items-center justify-center lg:items-start">
                            <div class="flex items-center truncate sm:whitespace-normal">
                                <x-base.lucide class="mr-2 h-4 w-4" icon="Mail" /> {{ $user->email }}
                            </div>
                            <div class="mt-3 flex items-center truncate sm:whitespace-normal">
                                <x-base.lucide class="mr-2 h-4 w-4" icon="Shield" />
                                {{ $user->roles->pluck('name')->implode(', ') ?: 'Sin rol asignado' }}
                            </div>
                            @if ($user->provider)
                                <div class="mt-3 flex items-center truncate sm:whitespace-normal">
                                    <x-base.lucide class="mr-2 h-4 w-4" icon="Link" /> Conectado con {{ ucfirst($user->provider) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información personal --}}
            <div class="intro-y box mt-5">
                <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
                    <h2 class="mr-auto text-base font-medium">Información Personal</h2>
                    <a href="{{ route('profile.edit') }}">
                        <x-base.button class="px-3 py-1.5" type="button" variant="primary">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" /> Editar
                        </x-base.button>
                    </a>
                </div>
                <div class="grid grid-cols-12 gap-4 p-5">
                    @foreach ([
                        'Nombre' => $user->first_name,
                        'Apellido' => $user->last_name,
                        'Correo electrónico' => $user->email,
                        'Cargo' => $user->position,
                        'Género' => ['male' => 'Masculino', 'female' => 'Femenino', 'other' => 'Otro'][$user->gender] ?? null,
                        'Estado' => $user->active ? 'Activo' : 'Inactivo',
                        'Miembro desde' => $user->created_at?->format('d/m/Y'),
                        'Última actualización' => $user->updated_at?->format('d/m/Y H:i'),
                    ] as $etiqueta => $valor)
                        <div class="col-span-12 sm:col-span-6">
                            <div class="text-xs text-slate-500">{{ $etiqueta }}</div>
                            <div class="mt-1 font-medium">{{ $valor ?: '—' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
