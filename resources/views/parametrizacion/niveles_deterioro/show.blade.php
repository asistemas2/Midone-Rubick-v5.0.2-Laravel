@extends('../layouts/' . $layout)

@section('subhead')
    <title>Detalle Nivel de Deterioro - Parametrización ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Detalle: {{ $nivel->nombre }}</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('parametrizacion.niveles_deterioro.index') }}" class="hover:text-primary">Niveles de Deterioro</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" /><span>Detalle</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <div class="flex items-center border-b border-slate-200/60 pb-5 dark:border-darkmode-400">
                    <div class="text-base font-medium truncate">{{ $nivel->nombre }}</div>
                    <div class="ml-auto">
                        <span @class(['rounded-full px-3 py-1 text-xs font-medium text-white', 'bg-success' => $nivel->activo, 'bg-danger' => !$nivel->activo])>
                            {{ $nivel->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
                <div class="mt-5 space-y-4">
                    <div class="flex items-center"><span class="w-32 text-slate-500">Código:</span><span class="font-medium">{{ $nivel->codigo }}</span></div>
                    <div class="flex items-center">
                        <span class="w-32 text-slate-500">Color:</span>
                        <div class="flex items-center gap-2">
                            <div class="h-6 w-6 rounded-full border border-slate-200" style="background-color: {{ $nivel->color_hex }}"></div>
                            <span class="font-medium">{{ $nivel->color_hex }}</span>
                        </div>
                    </div>
                    <div class="flex items-center"><span class="w-32 text-slate-500">Orden:</span><span class="font-medium">{{ $nivel->orden }}</span></div>
                    <div class="flex items-center"><span class="w-32 text-slate-500">Creado:</span><span class="font-medium">{{ $nivel->created_at->format('d/m/Y H:i') }}</span></div>
                    <div class="flex items-center"><span class="w-32 text-slate-500">Actualizado:</span><span class="font-medium">{{ $nivel->updated_at->format('d/m/Y H:i') }}</span></div>
                </div>
                <div class="mt-5 flex justify-end border-t border-slate-200/60 pt-5 dark:border-darkmode-400">
                    <a href="{{ route('parametrizacion.niveles_deterioro.index') }}"><x-base.button class="mr-2 w-24" type="button" variant="outline-secondary">Volver</x-base.button></a>
                    <a href="{{ route('parametrizacion.niveles_deterioro.edit', $nivel) }}"><x-base.button class="w-24" type="button" variant="primary">Editar</x-base.button></a>
                </div>
            </div>
        </div>
    </div>
@endsection
