<!-- BEGIN: Top Bar -->
<div class="relative z-[51] flex h-[67px] items-center border-b border-slate-200">
    <!-- BEGIN: Breadcrumb -->
    <x-base.breadcrumb class="-intro-x mr-auto hidden sm:flex">
        <x-base.breadcrumb.link :index="0">Application</x-base.breadcrumb.link>
        <x-base.breadcrumb.link :index="1" :active="true">
            Dashboard
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
    <!-- END: Breadcrumb -->

    <!-- BEGIN: Search -->
    <div class="search intro-x relative mr-3 sm:mr-6">
        <div class="relative hidden sm:block">
            <x-base.form-input
                class="w-56 rounded-full border-transparent bg-slate-300/50 pr-8 shadow-none transition-[width] duration-300 ease-in-out focus:w-72 focus:border-transparent dark:bg-darkmode-400/70"
                type="text"
                placeholder="Search..."
            />
            <x-base.lucide
                class="absolute inset-y-0 right-0 my-auto mr-3 h-5 w-5 text-slate-600 dark:text-slate-500"
                icon="Search"
            />
        </div>
        <a class="relative text-slate-600 sm:hidden" href="">
            <x-base.lucide class="h-5 w-5 dark:text-slate-500" icon="Search" />
        </a>
        <!-- El search result se mantiene igual, pero puedes adaptarlo si quieres -->
    </div>
    <!-- END: Search -->

    <!-- BEGIN: Notifications -->
    <x-base.popover class="intro-x mr-auto sm:mr-6">
        <x-base.popover.button
            class="relative block text-slate-600 outline-none before:absolute before:top-[-2px] before:right-0 before:h-[8px] before:w-[8px] before:rounded-full before:bg-danger before:content-['']"
        >
            <x-base.lucide class="h-5 w-5 dark:text-slate-500" icon="Bell" />
        </x-base.popover.button>
        <x-base.popover.panel class="mt-2 w-[280px] p-5 sm:w-[350px]">
            <div class="mb-5 font-medium">Notifications</div>
            @foreach (array_slice($fakers, 0, 5) as $fakerKey => $faker)
                <div @class([
                    'cursor-pointer relative flex items-center',
                    'mt-5' => $fakerKey,
                ])>
                    <div class="image-fit relative mr-1 h-12 w-12 flex-none">
                        <img class="rounded-full" src="{{ Vite::asset($faker['photos'][0]) }}" alt="Midone Tailwind HTML Admin Template" />
                        <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-success dark:border-darkmode-600"></div>
                    </div>
                    <div class="ml-2 overflow-hidden">
                        <div class="flex items-center">
                            <a class="mr-5 truncate font-medium" href="">{{ $faker['users'][0]['name'] }}</a>
                            <div class="ml-auto whitespace-nowrap text-xs text-slate-400">{{ $faker['times'][0] }}</div>
                        </div>
                        <div class="mt-0.5 w-full truncate text-slate-500">{{ $faker['news'][0]['short_content'] }}</div>
                    </div>
                </div>
            @endforeach
        </x-base.popover.panel>
    </x-base.popover>
    <!-- END: Notifications -->

    <!-- BEGIN: Account Menu -->
    <x-base.menu>
        <x-base.menu.button
            class="image-fit zoom-in intro-x block h-8 w-8 scale-110 overflow-hidden rounded-full shadow-lg"
        >
            <img
                src="{{ auth()->user()->avatar ?? Vite::asset('resources/images/default-avatar.png') }}"
                alt="{{ auth()->user()->full_name }}"
            />
        </x-base.menu.button>
        <x-base.menu.items
            class="relative mt-px w-56 bg-primary/80 text-white before:absolute before:inset-0 before:z-[-1] before:block before:rounded-md before:bg-black"
        >
            <x-base.menu.header class="font-normal">
                <div class="font-medium">{{ auth()->user()->full_name }}</div>
                <div class="mt-0.5 text-xs text-white/70 dark:text-slate-500">
                    {{ auth()->user()->position ?? 'Sin cargo' }}
                </div>
                @if(auth()->user()->roles->isNotEmpty())
                    <div class="mt-1">
                        <span class="inline-block rounded bg-white/20 px-2 py-0.5 text-xs font-medium text-white">
                            {{ auth()->user()->roles->first()->name }}
                        </span>
                    </div>
                @endif
            </x-base.menu.header>

            <x-base.menu.divider class="bg-white/[0.08]" />

            {{-- Mi Perfil --}}
            <x-base.menu.item class="hover:bg-white/5">
                <a href="{{ route('profile.overview') }}" class="flex w-full items-center">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="User" />
                    Mi Perfil
                </a>
            </x-base.menu.item>

            {{-- Editar Perfil --}}
            <x-base.menu.item class="hover:bg-white/5">
                <a href="{{ route('profile.edit') }}" class="flex w-full items-center">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" />
                    Editar Perfil
                </a>
            </x-base.menu.item>

            {{-- Cambiar Contraseña --}}
            <x-base.menu.item class="hover:bg-white/5">
                <a href="{{ route('profile.password') }}" class="flex w-full items-center">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Lock" />
                    Cambiar Contraseña
                </a>
            </x-base.menu.item>

            {{-- Gestionar Usuarios (solo administradores) --}}
            @role('Administrador')
                <x-base.menu.divider class="bg-white/[0.08]" />
                <x-base.menu.item class="hover:bg-white/5">
                    <a href="{{ route('gestion.usuarios.index') }}" class="flex w-full items-center">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Users" />
                        Gestionar Usuarios
                    </a>
                </x-base.menu.item>
            @endrole

            <x-base.menu.divider class="bg-white/[0.08]" />

            {{-- Logout --}}
            <x-base.menu.item class="hover:bg-white/5">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex w-full items-center">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="ToggleRight" />
                        Cerrar Sesión
                    </button>
                </form>
            </x-base.menu.item>
        </x-base.menu.items>
    </x-base.menu>
    <!-- END: Account Menu -->
</div>
<!-- END: Top Bar -->

@once
    @push('scripts')
        @vite('resources/js/components/top-bar/index.js')
    @endpush
@endonce