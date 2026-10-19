{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- PESTAÑA: PRESUPUESTO APROBADO (Presupuesto Aprobado)                    --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}

{{-- ─── Tarjetas resumen ──────────────────────────────────────────── --}}
<div class="grid grid-cols-12 gap-5">
    {{-- Total Anual Aprobado --}}
    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="box p-5">
            <div class="flex items-center">
                <x-base.lucide class="h-5 w-5 text-primary" icon="DollarSign" />
                <div class="ml-2 text-base text-slate-500">Total Anual Aprobado</div>
            </div>
            <div class="mt-2 text-2xl font-medium text-primary">
                ${{ number_format($totalAnualPresupuesto, 2, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">
                {{ $mantenimientosPresupuesto->count() }} programados / en proceso
            </div>
        </div>
    </div>

    {{-- Preventivos --}}
    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="box p-5">
            <div class="flex items-center">
                <x-base.lucide class="h-5 w-5 text-success" icon="ShieldCheck" />
                <div class="ml-2 text-base text-slate-500">Preventivos</div>
            </div>
            <div class="mt-2 text-2xl font-medium text-success">
                ${{ number_format($totalesPorTipoPresupuesto['preventivo']['total'] ?? 0, 2, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">
                {{ $totalesPorTipoPresupuesto['preventivo']['count'] ?? 0 }} mantenimientos
            </div>
        </div>
    </div>

    {{-- Correctivos --}}
    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="box p-5">
            <div class="flex items-center">
                <x-base.lucide class="h-5 w-5 text-danger" icon="AlertTriangle" />
                <div class="ml-2 text-base text-slate-500">Correctivos</div>
            </div>
            <div class="mt-2 text-2xl font-medium text-danger">
                ${{ number_format($totalesPorTipoPresupuesto['correctivo']['total'] ?? 0, 2, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">
                {{ $totalesPorTipoPresupuesto['correctivo']['count'] ?? 0 }} mantenimientos
            </div>
        </div>
    </div>

    {{-- Predictivos --}}
    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="box p-5">
            <div class="flex items-center">
                <x-base.lucide class="h-5 w-5 text-warning" icon="TrendingUp" />
                <div class="ml-2 text-base text-slate-500">Predictivos</div>
            </div>
            <div class="mt-2 text-2xl font-medium text-warning">
                ${{ number_format($totalesPorTipoPresupuesto['predictivo']['total'] ?? 0, 2, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">
                {{ $totalesPorTipoPresupuesto['predictivo']['count'] ?? 0 }} mantenimientos
            </div>
        </div>
    </div>
</div>

{{-- ─── Desglose por tipo de activo y por responsable ─────────────── --}}
<div class="mt-5 grid grid-cols-12 gap-5">
    {{-- Presupuesto aprobado por tipo de activo --}}
    <div class="col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h3 class="text-base font-medium mb-3">Presupuesto Aprobado por Tipo de Activo</h3>
            <x-base.table class="border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="border-b-0">TIPO</x-base.table.th>
                        <x-base.table.th class="border-b-0 text-center">CANTIDAD</x-base.table.th>
                        <x-base.table.th class="border-b-0 text-right">TOTAL APROBADO</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @forelse($totalesPorActivoPresupuesto as $tipo => $data)
                        <x-base.table.tr>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">{{ ucfirst($tipo) }}</x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center dark:bg-darkmode-600">{{ $data['count'] }}</x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-right font-medium text-primary dark:bg-darkmode-600">${{ number_format($data['total'], 2, ',', '.') }}</x-base.table.td>
                        </x-base.table.tr>
                    @empty
                        <x-base.table.tr>
                            <x-base.table.td colspan="3" class="border-b-0 bg-white text-center text-slate-500 dark:bg-darkmode-600">Sin datos</x-base.table.td>
                        </x-base.table.tr>
                    @endforelse
                </x-base.table.tbody>
            </x-base.table>
        </div>
    </div>

    {{-- Presupuesto aprobado por responsable --}}
    <div class="col-span-12 lg:col-span-6">
        <div class="box p-5">
            <h3 class="text-base font-medium mb-3">Presupuesto Aprobado por Responsable</h3>
            <x-base.table class="border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="border-b-0">RESPONSABLE</x-base.table.th>
                        <x-base.table.th class="border-b-0 text-center">CANTIDAD</x-base.table.th>
                        <x-base.table.th class="border-b-0 text-right">TOTAL APROBADO</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @forelse($totalesPorResponsablePresupuesto as $resp => $data)
                        <x-base.table.tr>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">{{ $resp }}</x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center dark:bg-darkmode-600">{{ $data['count'] }}</x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-right font-medium text-primary dark:bg-darkmode-600">${{ number_format($data['total'], 2, ',', '.') }}</x-base.table.td>
                        </x-base.table.tr>
                    @empty
                        <x-base.table.tr>
                            <x-base.table.td colspan="3" class="border-b-0 bg-white text-center text-slate-500 dark:bg-darkmode-600">Sin datos</x-base.table.td>
                        </x-base.table.tr>
                    @endforelse
                </x-base.table.tbody>
            </x-base.table>
        </div>
    </div>
</div>

{{-- ─── Detalle por mes en acordeón ──────────────────────────────── --}}
<h3 class="text-lg font-medium mt-8">Detalle por Mes (Presupuesto Aprobado)</h3>
<p class="text-sm text-slate-500 mt-1">Haz clic en cada mes para expandir el detalle de mantenimientos programados.</p>

<div class="mt-4 space-y-3">
    @forelse($porMesPresupuesto as $mes => $items)
        @php
            $nombreMes = \Carbon\Carbon::create()->month((int)$mes)->translatedFormat('F');
            $totalMes = $totalesPorMesPresupuesto[$mes] ?? 0;
        @endphp

        <details class="box group p-0 overflow-hidden">
            {{-- Encabezado del acordeón --}}
            <summary class="flex items-center cursor-pointer list-none px-5 py-4 hover:bg-slate-50 dark:hover:bg-darkmode-400 transition">
                <div class="flex items-center">
                    <x-base.lucide class="h-5 w-5 text-primary mr-3 transition-transform group-open:rotate-90" icon="ChevronRight" />
                    <x-base.lucide class="h-5 w-5 text-primary mr-2" icon="Calendar" />
                    <div>
                        <div class="text-base font-medium">{{ $nombreMes }} {{ $anio }}</div>
                        <div class="text-xs text-slate-500">{{ $items->count() }} mantenimiento(s)</div>
                    </div>
                </div>
                <div class="ml-auto text-right">
                    <div class="text-xs text-slate-500">Total aprobado</div>
                    <div class="text-base font-medium text-primary">${{ number_format($totalMes, 2, ',', '.') }}</div>
                </div>
            </summary>

            {{-- Contenido del acordeón --}}
            <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-4">
                <div class="overflow-x-auto">
                    <x-base.table class="border-separate border-spacing-y-[10px]">
                        <x-base.table.thead>
                            <x-base.table.tr>
                                <x-base.table.th class="whitespace-nowrap border-b-0">CÓDIGO</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0">ACTIVO</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0">TIPO MANT.</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0">DESCRIPCIÓN</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0">RESPONSABLE</x-base.table.th>
                                <x-base.table.th class="whitespace-nowrap border-b-0 text-right">PRESUPUESTO APROBADO</x-base.table.th>
                            </x-base.table.tr>
                        </x-base.table.thead>
                        <x-base.table.tbody>
                            @foreach($items as $mantenimiento)
                                <x-base.table.tr class="intro-x">
                                    <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                        <a href="{{ route('gestion.mantenimientos.show', $mantenimiento) }}" class="font-medium text-primary">{{ $mantenimiento->codigo }}</a>
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                        <div class="font-medium">{{ $mantenimiento->nombre_activo }}</div>
                                        <div class="text-xs text-slate-500">{{ ucfirst($mantenimiento->tipo_activo) }}</div>
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                        {!! $mantenimiento->tipo_mantenimiento_badge !!}
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                        <div class="max-w-md truncate" title="{{ $mantenimiento->descripcion }}">{{ Str::limit($mantenimiento->descripcion, 70) }}</div>
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                        <span class="rounded-full bg-slate-100 px-2 py-1 text-xs dark:bg-darkmode-400">{{ $mantenimiento->tipo_responsable }}</span>
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b-0 bg-white text-right font-medium text-primary shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                        ${{ number_format($mantenimiento->presupuesto_aprobado, 2, ',', '.') }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                            @endforeach
                            <x-base.table.tr class="bg-slate-50 dark:bg-darkmode-700">
                                <x-base.table.td colspan="5" class="border-b-0 text-right font-medium">TOTAL {{ strtoupper($nombreMes) }}:</x-base.table.td>
                                <x-base.table.td class="border-b-0 text-right font-bold text-primary">${{ number_format($totalMes, 2, ',', '.') }}</x-base.table.td>
                            </x-base.table.tr>
                        </x-base.table.tbody>
                    </x-base.table>
                </div>
            </div>
        </details>
    @empty
        <div class="box p-8 text-center text-slate-500">
            <x-base.lucide class="mx-auto h-10 w-10 text-slate-300" icon="Inbox" />
            <div class="mt-2">No hay mantenimientos programados o en proceso para {{ $anio }}.</div>
        </div>
    @endforelse
</div>

{{-- ─── Total anual aprobado ─────────────────────────────────────── --}}
<div class="intro-y box mt-5 p-5 bg-primary/5">
    <div class="flex flex-col sm:flex-row sm:items-center">
        <div class="flex items-center">
            <x-base.lucide class="h-6 w-6 text-primary mr-2" icon="DollarSign" />
            <h3 class="text-lg font-medium">TOTAL ANUAL APROBADO</h3>
        </div>
        <div class="mt-2 sm:mt-0 sm:ml-auto text-2xl font-bold text-primary">
            ${{ number_format($totalAnualPresupuesto, 2, ',', '.') }}
        </div>
    </div>
    <div class="mt-1 text-sm text-slate-500">
        {{ $mantenimientosPresupuesto->count() }} mantenimientos programados en {{ $anio }}.
    </div>
</div>