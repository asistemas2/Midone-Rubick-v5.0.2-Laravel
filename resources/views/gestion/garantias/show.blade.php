@extends('../layouts/' . $layout)

@section('subhead')
    <title>{{ $garantia->codigo }} - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Detalle de Garantía</h2>
        <a href="{{ route('gestion.garantias.edit', $garantia) }}">
            <x-base.button variant="primary" class="mr-2 shadow-md">
                <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" /> Editar
            </x-base.button>
        </a>
        <a href="{{ route('gestion.garantias.index') }}">
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
                        <div class="text-base font-medium">{{ $garantia->codigo }}</div>
                        <div class="mt-1 text-slate-500">{{ $garantia->proveedor ?? 'Sin proveedor' }}</div>
                    </div>
                    <div class="ml-auto">{!! $garantia->estado_badge !!}</div>
                </div>
                <div class="mt-5 grid grid-cols-12 gap-4">
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Mantenimiento</div>
                        <div class="mt-1 font-medium">
                            @if($garantia->mantenimiento)
                                <a href="{{ route('gestion.mantenimientos.show', $garantia->mantenimiento) }}" class="text-primary">{{ $garantia->mantenimiento->codigo }}</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Tipo Activo</div>
                        <div class="mt-1 font-medium">{{ ucfirst($garantia->tipo_activo) }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Monto</div>
                        <div class="mt-1 font-medium">{{ $garantia->monto ? '$ ' . number_format($garantia->monto, 2) : '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Fecha Inicio</div>
                        <div class="mt-1 font-medium">{{ $garantia->fecha_inicio?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Fecha Fin</div>
                        <div class="mt-1 font-medium">{{ $garantia->fecha_fin?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Días Restantes</div>
                        <div class="mt-1 font-medium">
                            @if($garantia->dias_restantes !== null)
                                <span class="{{ $garantia->dias_restantes > 30 ? 'text-success' : ($garantia->dias_restantes > 0 ? 'text-warning' : 'text-danger') }}">
                                    {{ $garantia->dias_restantes > 0 ? $garantia->dias_restantes . ' días' : 'Vencida' }}
                                </span>
                            @else
                                —
                            @endif
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Vigente</div>
                        <div class="mt-1 font-medium">
                            @if($garantia->esta_vigente)
                                <span class="text-success"><x-base.lucide class="inline h-4 w-4" icon="CheckCircle" /> Sí</span>
                            @else
                                <span class="text-danger"><x-base.lucide class="inline h-4 w-4" icon="XCircle" /> No</span>
                            @endif
                        </div>
                    </div>
                    @if($garantia->terminos)
                    <div class="col-span-12">
                        <div class="text-xs text-slate-500">Términos y Condiciones</div>
                        <div class="mt-1 rounded-md bg-slate-50 p-3 dark:bg-darkmode-400">{{ $garantia->terminos }}</div>
                    </div>
                    @endif
                    @if($garantia->observaciones)
                    <div class="col-span-12">
                        <div class="text-xs text-slate-500">Observaciones</div>
                        <div class="mt-1">{{ $garantia->observaciones }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
