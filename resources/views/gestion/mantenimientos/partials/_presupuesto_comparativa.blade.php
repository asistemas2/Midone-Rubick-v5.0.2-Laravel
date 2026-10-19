{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- PESTAÑA: COMPARATIVA (Presupuesto Aprobado vs Costo Real Ejecutado)       --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}

@php
    $desviacionTotal = $totalAnualEjecutado - $totalAnualPresupuesto;
    $porcentajeDesviacion = $totalAnualPresupuesto > 0
        ? ($desviacionTotal / $totalAnualPresupuesto) * 100
        : 0;
@endphp

{{-- ─── Tarjetas de resumen general ──────────────────────────────── --}}
<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="box p-5">
            <div class="flex items-center">
                <x-base.lucide class="h-5 w-5 text-primary" icon="ClipboardList" />
                <div class="ml-2 text-base text-slate-500">Total Aprobado</div>
            </div>
            <div class="mt-2 text-2xl font-medium text-primary">
                ${{ number_format($totalAnualPresupuesto, 2, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">
                {{ $mantenimientosPresupuesto->count() }} programados / en proceso
            </div>
        </div>
    </div>
    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="box p-5">
            <div class="flex items-center">
                <x-base.lucide class="h-5 w-5 text-success" icon="CheckCircle" />
                <div class="ml-2 text-base text-slate-500">Total Real Ejecutado</div>
            </div>
            <div class="mt-2 text-2xl font-medium text-success">
                ${{ number_format($totalAnualEjecutado, 2, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">
                {{ $mantenimientosEjecutado->count() }} completados
            </div>
        </div>
    </div>
    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="box p-5">
            <div class="flex items-center">
                <x-base.lucide class="h-5 w-5 {{ $desviacionTotal >= 0 ? 'text-danger' : 'text-success' }}" icon="TrendingUp" />
                <div class="ml-2 text-base text-slate-500">Desviación Total</div>
            </div>
            <div class="mt-2 text-2xl font-medium {{ $desviacionTotal >= 0 ? 'text-danger' : 'text-success' }}">
                {{ $desviacionTotal >= 0 ? '+' : '' }}${{ number_format($desviacionTotal, 2, ',', '.') }}
            </div>
            <div class="mt-1 text-xs text-slate-500">
                {{ $desviacionTotal >= 0 ? 'Se gastó más' : 'Se gastó menos' }} de lo aprobado
            </div>
        </div>
    </div>
    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
        <div class="box p-5">
            <div class="flex items-center">
                <x-base.lucide class="h-5 w-5 {{ $desviacionTotal >= 0 ? 'text-danger' : 'text-success' }}" icon="Percent" />
                <div class="ml-2 text-base text-slate-500">Variación %</div>
            </div>
            <div class="mt-2 text-2xl font-medium {{ $desviacionTotal >= 0 ? 'text-danger' : 'text-success' }}">
                {{ $desviacionTotal >= 0 ? '+' : '' }}{{ number_format($porcentajeDesviacion, 2) }}%
            </div>
            <div class="mt-1 text-xs text-slate-500">
                Sobre el total aprobado anual
            </div>
        </div>
    </div>
</div>

{{-- ─── Acordeón de comparativa por mes ──────────────────────────── --}}
<h3 class="text-lg font-medium mt-8">Comparativa Mensual: Aprobado vs Real</h3>
<p class="text-sm text-slate-500 mt-1">
    Haz clic en cada mes para ver el detalle. La desviación es <strong>Real − Aprobado</strong>.
</p>

<div class="mt-4 space-y-3">
    @foreach($comparativaPorMes as $mes => $data)
        @php
            $nombreMes = \Carbon\Carbon::create()->month((int)$mes)->translatedFormat('F');
            $aprobado = $data['aprobado'];
            $real = $data['real'];
            $desv = $data['desviacion'];

            // Estado y colores
            if ($aprobado == 0 && $real == 0) {
                $estado = 'Sin datos';
                $estadoColor = 'bg-slate-100 text-slate-500 dark:bg-darkmode-400';
                $borderColor = 'border-slate-200 dark:border-darkmode-400';
                $iconColor = 'text-slate-400';
            } elseif ($desv > 0) {
                $estado = 'Sobrecosto';
                $estadoColor = 'bg-danger/10 text-danger';
                $borderColor = 'border-danger/30';
                $iconColor = 'text-danger';
            } elseif ($desv < 0) {
                $estado = 'Ahorro';
                $estadoColor = 'bg-success/10 text-success';
                $borderColor = 'border-success/30';
                $iconColor = 'text-success';
            } else {
                $estado = 'Exacto';
                $estadoColor = 'bg-primary/10 text-primary';
                $borderColor = 'border-primary/30';
                $iconColor = 'text-primary';
            }

            // Porcentaje de variación del mes
            $porcentajeMes = $aprobado > 0 ? ($desv / $aprobado) * 100 : 0;

            // Filtrar los mantenimientos presupuestados y reales de este mes
            $itemsAprobado = $porMesPresupuesto[$mes] ?? collect();
            $itemsReal = $porMesEjecutado[$mes] ?? collect();
        @endphp

        <details class="box group p-0 overflow-hidden border-l-4 {{ $borderColor }}">
            {{-- Encabezado del acordeón --}}
            <summary class="flex items-center cursor-pointer list-none px-5 py-4 hover:bg-slate-50 dark:hover:bg-darkmode-400 transition">
                <div class="flex items-center">
                    <x-base.lucide class="h-5 w-5 {{ $iconColor }} mr-3 transition-transform group-open:rotate-90" icon="ChevronRight" />
                    <x-base.lucide class="h-5 w-5 {{ $iconColor }} mr-2" icon="Calendar" />
                    <div>
                        <div class="text-base font-medium">{{ $nombreMes }} {{ $anio }}</div>
                        <div class="mt-0.5 flex items-center gap-2">
                            <span class="rounded-full {{ $estadoColor }} px-2 py-0.5 text-xs font-medium">
                                {{ $estado }}
                            </span>
                            @if($aprobado > 0 || $real > 0)
                                <span class="text-xs text-slate-500">
                                    {{ $itemsAprobado->count() + $itemsReal->count() }} movimiento(s)
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="ml-auto grid grid-cols-3 gap-4 text-right">
                    <div>
                        <div class="text-xs text-slate-500">Aprobado</div>
                        <div class="text-sm font-medium text-primary">${{ number_format($aprobado, 2, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500">Real</div>
                        <div class="text-sm font-medium text-success">${{ number_format($real, 2, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500">Desviación</div>
                        <div class="text-sm font-bold {{ $desv >= 0 ? 'text-danger' : 'text-success' }}">
                            {{ $desv >= 0 ? '+' : '' }}${{ number_format($desv, 2, ',', '.') }}
                        </div>
                        @if($aprobado > 0)
                            <div class="text-xs {{ $desv >= 0 ? 'text-danger' : 'text-success' }}">
                                {{ $desv >= 0 ? '+' : '' }}{{ number_format($porcentajeMes, 2) }}%
                            </div>
                        @endif
                    </div>
                </div>
            </summary>

            {{-- Contenido del acordeón --}}
            <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-5 py-4 bg-slate-50/50 dark:bg-darkmode-700/30">

                {{-- Bloque: Mantenimientos con presupuesto aprobado (programados/en proceso) --}}
                @if($itemsAprobado->isNotEmpty())
                    <div class="mb-4">
                        <div class="flex items-center mb-2">
                            <x-base.lucide class="h-4 w-4 text-primary mr-2" icon="ClipboardList" />
                            <h4 class="text-sm font-medium text-primary">
                                Aprobados ({{ $itemsAprobado->count() }})
                            </h4>
                            <span class="ml-auto text-sm font-medium text-primary">
                                ${{ number_format($aprobado, 2, ',', '.') }}
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <x-base.table class="border-separate border-spacing-y-[6px]">
                                <x-base.table.thead>
                                    <x-base.table.tr>
                                        <x-base.table.th class="border-b-0 text-xs">CÓDIGO</x-base.table.th>
                                        <x-base.table.th class="border-b-0 text-xs">ACTIVO</x-base.table.th>
                                        <x-base.table.th class="border-b-0 text-xs">TIPO MANT.</x-base.table.th>
                                        <x-base.table.th class="border-b-0 text-xs">DESCRIPCIÓN</x-base.table.th>
                                        <x-base.table.th class="border-b-0 text-xs">RESPONSABLE</x-base.table.th>
                                        <x-base.table.th class="border-b-0 text-xs text-right">PRESUPUESTO APROBADO</x-base.table.th>
                                    </x-base.table.tr>
                                </x-base.table.thead>
                                <x-base.table.tbody>
                                    @foreach($itemsAprobado as $mant)
                                        <x-base.table.tr>
                                            <x-base.table.td class="border-b-0 bg-white text-xs dark:bg-darkmode-600">
                                                <a href="{{ route('gestion.mantenimientos.show', $mant) }}" class="font-medium text-primary">{{ $mant->codigo }}</a>
                                            </x-base.table.td>
                                            <x-base.table.td class="border-b-0 bg-white text-xs dark:bg-darkmode-600">
                                                <div>{{ $mant->nombre_activo }}</div>
                                                <div class="text-slate-500">{{ ucfirst($mant->tipo_activo) }}</div>
                                            </x-base.table.td>
                                            <x-base.table.td class="border-b-0 bg-white text-xs dark:bg-darkmode-600">
                                                {!! $mant->tipo_mantenimiento_badge !!}
                                            </x-base.table.td>
                                            <x-base.table.td class="border-b-0 bg-white text-xs dark:bg-darkmode-600">
                                                <div class="max-w-md truncate" title="{{ $mant->descripcion }}">{{ Str::limit($mant->descripcion, 60) }}</div>
                                            </x-base.table.td>
                                            <x-base.table.td class="border-b-0 bg-white text-xs dark:bg-darkmode-600">
                                                {{ $mant->tipo_responsable }}
                                            </x-base.table.td>
                                            <x-base.table.td class="border-b-0 bg-white text-xs text-right font-medium text-primary dark:bg-darkmode-600">
                                                ${{ number_format($mant->presupuesto_aprobado, 2, ',', '.') }}
                                            </x-base.table.td>
                                        </x-base.table.tr>
                                    @endforeach
                                </x-base.table.tbody>
                            </x-base.table>
                        </div>
                    </div>
                @endif

                {{-- Bloque: Mantenimientos Reales (completados) --}}
                @if($itemsReal->isNotEmpty())
                    <div>
                        <div class="flex items-center mb-2">
                            <x-base.lucide class="h-4 w-4 text-success mr-2" icon="CheckCircle" />
                            <h4 class="text-sm font-medium text-success">
                                Reales Ejecutados ({{ $itemsReal->count() }})
                            </h4>
                            <span class="ml-auto text-sm font-medium text-success">
                                ${{ number_format($real, 2, ',', '.') }}
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <x-base.table class="border-separate border-spacing-y-[6px]">
                                <x-base.table.thead>
                                    <x-base.table.tr>
                                        <x-base.table.th class="border-b-0 text-xs">CÓDIGO</x-base.table.th>
                                        <x-base.table.th class="border-b-0 text-xs">ACTIVO</x-base.table.th>
                                        <x-base.table.th class="border-b-0 text-xs">TIPO MANT.</x-base.table.th>
                                        <x-base.table.th class="border-b-0 text-xs">DESCRIPCIÓN</x-base.table.th>
                                        <x-base.table.th class="border-b-0 text-xs">RESPONSABLE</x-base.table.th>
                                        <x-base.table.th class="border-b-0 text-xs text-right">COSTO REAL</x-base.table.th>
                                    </x-base.table.tr>
                                </x-base.table.thead>
                                <x-base.table.tbody>
                                    @foreach($itemsReal as $mant)
                                        <x-base.table.tr>
                                            <x-base.table.td class="border-b-0 bg-white text-xs dark:bg-darkmode-600">
                                                <a href="{{ route('gestion.mantenimientos.show', $mant) }}" class="font-medium text-primary">{{ $mant->codigo }}</a>
                                            </x-base.table.td>
                                            <x-base.table.td class="border-b-0 bg-white text-xs dark:bg-darkmode-600">
                                                <div>{{ $mant->nombre_activo }}</div>
                                                <div class="text-slate-500">{{ ucfirst($mant->tipo_activo) }}</div>
                                            </x-base.table.td>
                                            <x-base.table.td class="border-b-0 bg-white text-xs dark:bg-darkmode-600">
                                                {!! $mant->tipo_mantenimiento_badge !!}
                                            </x-base.table.td>
                                            <x-base.table.td class="border-b-0 bg-white text-xs dark:bg-darkmode-600">
                                                <div class="max-w-md truncate" title="{{ $mant->descripcion }}">{{ Str::limit($mant->descripcion, 60) }}</div>
                                            </x-base.table.td>
                                            <x-base.table.td class="border-b-0 bg-white text-xs dark:bg-darkmode-600">
                                                {{ $mant->tipo_responsable }}
                                            </x-base.table.td>
                                            <x-base.table.td class="border-b-0 bg-white text-xs text-right font-medium text-success dark:bg-darkmode-600">
                                                ${{ number_format($mant->costo_real, 2, ',', '.') }}
                                            </x-base.table.td>
                                        </x-base.table.tr>
                                    @endforeach
                                </x-base.table.tbody>
                            </x-base.table>
                        </div>
                    </div>
                @endif

                {{-- Bloque: Resumen del mes --}}
                @if($aprobado > 0 || $real > 0)
                    <div class="mt-4 pt-4 border-t border-slate-200/60 dark:border-darkmode-400">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div class="rounded-md bg-primary/5 p-3">
                                <div class="text-xs text-slate-500">Total Aprobado</div>
                                <div class="text-base font-medium text-primary">${{ number_format($aprobado, 2, ',', '.') }}</div>
                            </div>
                            <div class="rounded-md bg-success/5 p-3">
                                <div class="text-xs text-slate-500">Total Real Ejecutado</div>
                                <div class="text-base font-medium text-success">${{ number_format($real, 2, ',', '.') }}</div>
                            </div>
                            <div class="rounded-md {{ $desv >= 0 ? 'bg-danger/5' : 'bg-success/5' }} p-3">
                                <div class="text-xs text-slate-500">Desviación</div>
                                <div class="text-base font-bold {{ $desv >= 0 ? 'text-danger' : 'text-success' }}">
                                    {{ $desv >= 0 ? '+' : '' }}${{ number_format($desv, 2, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Mensaje si no hay datos --}}
                @if($aprobado == 0 && $real == 0)
                    <div class="text-center text-slate-500 py-4">
                        <x-base.lucide class="mx-auto h-8 w-8 text-slate-300" icon="Inbox" />
                        <div class="mt-2 text-sm">Sin movimientos registrados este mes.</div>
                    </div>
                @endif
            </div>
        </details>
    @endforeach
</div>

{{-- ─── Resumen anual al pie ─────────────────────────────────────── --}}
<div class="intro-y box mt-5 p-5 {{ $desviacionTotal >= 0 ? 'bg-danger/5' : 'bg-success/5' }}">
    <div class="flex flex-col sm:flex-row sm:items-center">
        <div class="flex items-center">
            <x-base.lucide class="h-6 w-6 {{ $desviacionTotal >= 0 ? 'text-danger' : 'text-success' }} mr-2" icon="BarChart2" />
            <h3 class="text-lg font-medium">RESUMEN ANUAL {{ $anio }}</h3>
        </div>
        <div class="mt-2 sm:mt-0 sm:ml-auto grid grid-cols-3 gap-6 text-right">
            <div>
                <div class="text-xs text-slate-500">Aprobado</div>
                <div class="text-lg font-medium text-primary">${{ number_format($totalAnualPresupuesto, 2, ',', '.') }}</div>
            </div>
            <div>
                <div class="text-xs text-slate-500">Real Ejecutado</div>
                <div class="text-lg font-medium text-success">${{ number_format($totalAnualEjecutado, 2, ',', '.') }}</div>
            </div>
            <div>
                <div class="text-xs text-slate-500">Desviación</div>
                <div class="text-lg font-bold {{ $desviacionTotal >= 0 ? 'text-danger' : 'text-success' }}">
                    {{ $desviacionTotal >= 0 ? '+' : '' }}${{ number_format($desviacionTotal, 2, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2 text-sm text-slate-500">
        @if($desviacionTotal > 0)
            Se ejecutó <strong class="text-danger">${{ number_format($desviacionTotal, 2, ',', '.') }}</strong>
            más de lo aprobado (<strong>{{ number_format($porcentajeDesviacion, 2) }}%</strong> de sobrecosto).
        @elseif($desviacionTotal < 0)
            Se ejecutó <strong class="text-success">${{ number_format(abs($desviacionTotal), 2, ',', '.') }}</strong>
            menos de lo aprobado (<strong>{{ number_format(abs($porcentajeDesviacion), 2) }}%</strong> de ahorro).
        @else
            El presupuesto aprobado se ejecutó exactamente como se planeó.
        @endif
    </div>
</div>