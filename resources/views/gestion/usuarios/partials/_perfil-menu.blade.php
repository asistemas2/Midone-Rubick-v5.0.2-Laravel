{{-- Menú lateral del perfil (basado en "Profile Menu" de las demos update-profile / change-password) --}}
@php($usuario = auth()->user())

<div class="col-span-12 flex flex-col-reverse lg:col-span-4 lg:block 2xl:col-span-3">
    <div class="intro-y box mt-5">
        <div class="relative flex items-center p-5">
            <div class="image-fit h-12 w-12">
                <img
                    class="rounded-full"
                    src="{{ $usuario->avatar ?? Vite::asset('resources/images/default-avatar.png') }}"
                    alt="{{ $usuario->full_name }}"
                />
            </div>
            <div class="ml-4 mr-auto">
                <div class="text-base font-medium">{{ $usuario->full_name }}</div>
                <div class="text-slate-500">{{ $usuario->position ?? 'Sin cargo' }}</div>
            </div>
        </div>
        <div class="border-t border-slate-200/60 p-5 dark:border-darkmode-400">
            @foreach ([
                ['profile.overview', 'User', 'Mi Perfil'],
                ['profile.edit', 'Edit', 'Información Personal'],
                ['profile.password', 'Lock', 'Cambiar Contraseña'],
            ] as [$ruta, $icono, $texto])
                <a
                    @class(['flex items-center', 'mt-5' => !$loop->first, 'font-medium text-primary' => request()->routeIs($ruta)])
                    href="{{ route($ruta) }}"
                >
                    <x-base.lucide class="mr-2 h-4 w-4" icon="{{ $icono }}" /> {{ $texto }}
                </a>
            @endforeach
        </div>
        @if ($usuario->roles->isNotEmpty())
            <div class="flex flex-wrap gap-2 border-t border-slate-200/60 p-5 dark:border-darkmode-400">
                @foreach ($usuario->roles as $rol)
                    <span class="rounded-full bg-primary/10 px-2 py-1 text-xs text-primary">{{ $rol->name }}</span>
                @endforeach
            </div>
        @endif
    </div>
</div>
