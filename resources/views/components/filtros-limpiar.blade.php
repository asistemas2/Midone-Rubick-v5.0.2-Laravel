{{-- Botón "Limpiar filtros" para los listados: solo aparece si hay algún filtro aplicado --}}
@props(['route'])

@if (collect(request()->except('page'))->filter(fn ($valor) => filled($valor))->isNotEmpty())
    <a href="{{ route($route) }}" title="Limpiar filtros">
        <x-base.button class="!box h-full px-3 text-slate-500" type="button">
            <x-base.lucide class="h-4 w-4" icon="X" />
            <span class="ml-1 hidden xl:inline">Limpiar</span>
        </x-base.button>
    </a>
@endif
