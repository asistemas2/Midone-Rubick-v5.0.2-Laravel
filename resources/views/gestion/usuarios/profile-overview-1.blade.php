@extends('../layouts/' . $layout)

@section('subhead')
    <title>Mi Perfil - ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Mi Perfil</h2>
    </div>

    <div class="intro-y box mt-5 px-5 pt-5">
        <div class="-mx-5 flex flex-col border-b border-slate-200/60 pb-5 dark:border-darkmode-400 lg:flex-row">
            <div class="flex flex-1 items-center justify-center px-5 lg:justify-start">
                <div class="image-fit relative h-20 w-20 flex-none sm:h-24 sm:w-24 lg:h-32 lg:w-32">
                    <img
                        class="rounded-full"
                        src="{{ auth()->user()->avatar ?? Vite::asset('resources/images/default-avatar.png') }}"
                        alt="{{ auth()->user()->full_name }}"
                    />
                    <div class="absolute bottom-0 right-0 mb-1 mr-1 flex items-center justify-center rounded-full bg-primary p-2">
                        <x-base.lucide class="h-4 w-4 text-white" icon="Camera" />
                    </div>
                </div>
                <div class="ml-5">
                    <div class="text-lg font-medium">{{ auth()->user()->full_name }}</div>
                    <div class="text-slate-500">{{ auth()->user()->position ?? 'Sin cargo' }}</div>
                    @if(auth()->user()->roles->isNotEmpty())
                        <div class="mt-1">
                            <span class="badge bg-primary/10 text-primary">{{ auth()->user()->roles->first()->name }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-6 flex-1 border-t border-l border-r border-slate-200/60 px-5 pt-5 dark:border-darkmode-400 lg:mt-0 lg:border-t-0 lg:pt-0">
                <div class="text-center font-medium lg:mt-3 lg:text-left">Detalles de Contacto</div>
                <div class="mt-4 flex flex-col items-center justify-center lg:items-start">
                    <div class="flex items-center truncate sm:whitespace-normal">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Mail" />
                        {{ auth()->user()->email }}
                    </div>
                    @if(auth()->user()->provider)
                        <div class="mt-3 flex items-center truncate sm:whitespace-normal">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="Link" />
                            Conectado con {{ ucfirst(auth()->user()->provider) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 text-right">
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" />
            Editar Perfil
        </a>
    </div>
@endsection