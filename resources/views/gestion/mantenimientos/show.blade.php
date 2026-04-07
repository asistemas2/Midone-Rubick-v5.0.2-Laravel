@extends('../layouts/' . $layout)

@section('subhead')
    <title>{{ $mantenimiento->codigo }} - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Detalle del Mantenimiento</h2>
        <a href="{{ route('gestion.mantenimientos.edit', $mantenimiento) }}">
            <x-base.button variant="primary" class="mr-2 shadow-md">
                <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" /> Editar
            </x-base.button>
        </a>
        <a href="{{ route('gestion.mantenimientos.index') }}">
            <x-base.button variant="outline-secondary">
                <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft" /> Volver
            </x-base.button>
        </a>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                <div class="flex items-center border-b border-slate-200/60 pb-5 dark:border-darkmode-400">
                    <div>
                        <div class="text-base font-medium">{{ $mantenimiento->codigo }}</div>
                        <div class="mt-1 text-slate-500">{{ ucfirst($mantenimiento->tipo_activo) }} • {{ $mantenimiento->nombre_activo }}</div>
                    </div>
                    <div class="ml-auto flex gap-2">
                        {!! $mantenimiento->tipo_mantenimiento_badge !!}
                        {!! $mantenimiento->estado_badge !!}
                    </div>
                </div>
                <div class="mt-5 grid grid-cols-12 gap-4">
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Fecha Programada</div>
                        <div class="mt-1 font-medium">{{ $mantenimiento->fecha_programada?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Fecha Realizada</div>
                        <div class="mt-1 font-medium">{{ $mantenimiento->fecha_realizada?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Tipo Responsable</div>
                        <div class="mt-1 font-medium">{{ $mantenimiento->tipo_responsable ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Responsable</div>
                        <div class="mt-1 font-medium">{{ $mantenimiento->responsable ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Empresa Contratista</div>
                        <div class="mt-1 font-medium">{{ $mantenimiento->empresa_contratista ?? '—' }}</div>
                    </div>
                    @if($mantenimiento->descripcion)
                    <div class="col-span-12">
                        <div class="text-xs text-slate-500">Descripción</div>
                        <div class="mt-1">{{ $mantenimiento->descripcion }}</div>
                    </div>
                    @endif
                    @if($mantenimiento->observaciones)
                    <div class="col-span-12">
                        <div class="text-xs text-slate-500">Observaciones</div>
                        <div class="mt-1">{{ $mantenimiento->observaciones }}</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Garantías --}}
            @if($mantenimiento->garantias->count())
            <div class="intro-y box mt-5 p-5">
                <div class="mb-3 flex items-center">
                    <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="ShieldCheck" />
                    <span class="text-base font-medium">Garantías ({{ $mantenimiento->garantias->count() }})</span>
                </div>
                <x-base.table class="border-separate border-spacing-y-[10px]">
                    <x-base.table.thead>
                        <x-base.table.tr>
                            <x-base.table.th class="border-b-0">Código</x-base.table.th>
                            <x-base.table.th class="border-b-0">Proveedor</x-base.table.th>
                            <x-base.table.th class="border-b-0">Vigencia</x-base.table.th>
                            <x-base.table.th class="border-b-0">Estado</x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                    <x-base.table.tbody>
                        @foreach($mantenimiento->garantias as $garantia)
                        <x-base.table.tr>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">
                                <a href="{{ route('gestion.garantias.show', $garantia) }}" class="text-primary">{{ $garantia->codigo }}</a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">{{ $garantia->proveedor ?? '—' }}</x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">
                                {{ $garantia->fecha_inicio?->format('d/m/Y') ?? '—' }} - {{ $garantia->fecha_fin?->format('d/m/Y') ?? '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">{!! $garantia->estado_badge !!}</x-base.table.td>
                        </x-base.table.tr>
                        @endforeach
                    </x-base.table.tbody>
                </x-base.table>
            </div>
            @endif
        </div>
    </div>
@endsection
