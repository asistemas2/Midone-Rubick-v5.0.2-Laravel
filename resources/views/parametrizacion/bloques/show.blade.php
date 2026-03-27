@extends('../layouts/' . $layout)

@section('subhead')
    <title>Detalle Bloque - Parametrización ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Detalle del Bloque: {{ $bloque->nombre }}</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('parametrizacion.bloques.index') }}" class="hover:text-primary">Bloques</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>Detalle</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <div class="flex items-center border-b border-slate-200/60 pb-5 dark:border-darkmode-400">
                    <div class="text-base font-medium truncate">{{ $bloque->nombre }}</div>
                    <div class="ml-auto">
                        <span @class(['rounded-full px-3 py-1 text-xs font-medium text-white', 'bg-success' => $bloque->activo, 'bg-danger' => !$bloque->activo])>
                            {{ $bloque->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
                <div class="mt-5 space-y-4">
                    <div class="flex items-center"><span class="w-32 text-slate-500">Código:</span><span class="font-medium">{{ $bloque->codigo }}</span></div>
                    <div class="flex items-center"><span class="w-32 text-slate-500">Área (m²):</span><span class="font-medium">{{ $bloque->area_m2 ? number_format($bloque->area_m2, 2) : '—' }}</span></div>
                    <div class="flex items-start"><span class="w-32 text-slate-500">Descripción:</span><span class="font-medium">{{ $bloque->descripcion ?? '—' }}</span></div>
                    <div class="flex items-center"><span class="w-32 text-slate-500">Creado:</span><span class="font-medium">{{ $bloque->created_at->format('d/m/Y H:i') }}</span></div>
                    <div class="flex items-center"><span class="w-32 text-slate-500">Actualizado:</span><span class="font-medium">{{ $bloque->updated_at->format('d/m/Y H:i') }}</span></div>
                </div>
                <div class="mt-5 flex justify-end border-t border-slate-200/60 pt-5 dark:border-darkmode-400">
                    <a href="{{ route('parametrizacion.bloques.index') }}">
                        <x-base.button class="mr-2 w-24" type="button" variant="outline-secondary">Volver</x-base.button>
                    </a>
                    <a href="{{ route('parametrizacion.bloques.edit', $bloque) }}">
                        <x-base.button class="w-24" type="button" variant="primary">Editar</x-base.button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
