@extends('../layouts/' . $layout)

@section('subhead')
    <title>Dashboard — Zona Franca Palmaseca</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">

                {{-- ═══════════════════════════════════════════════════════════
                     HERO BANNER
                ═══════════════════════════════════════════════════════════ --}}
                <div class="col-span-12 mt-8">
                    <div class="intro-y rounded-xl p-6 text-white"
                         style="background: linear-gradient(135deg, #1a3a5c 0%, #0d253f 100%); position: relative; overflow: hidden;">
                        <div class="absolute -right-10 -top-10 h-48 w-48 rounded-full" style="background: rgba(255,255,255,.04);"></div>
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h2 class="flex items-center text-2xl font-extrabold">
                                    <x-base.lucide class="mr-3 h-7 w-7" icon="Gauge" />
                                    Panel de Control
                                </h2>
                                <p class="mt-1 text-sm opacity-80">
                                    Sistema de Gestión de Inventario de Infraestructura Física — Zona Franca Palmaseca
                                </p>
                            </div>
                            <div class="mt-3 md:mt-0">
                                <span class="inline-block rounded-lg bg-white/90 px-4 py-2 text-sm font-semibold text-slate-700">
                                    {{ $today->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════
                     KPI CARDS
                ═══════════════════════════════════════════════════════════ --}}
                <div class="col-span-12 mt-2">
                    <div class="grid grid-cols-12 gap-6">
                        {{-- Inmuebles --}}
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <a href="{{ route('gestion.inmuebles.index') }}" class="block">
                                <div @class([
                                    'relative zoom-in',
                                    'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                                ])>
                                    <div class="box p-5">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-14 w-14 items-center justify-center rounded-xl" style="background: #e3f2fd;">
                                                <x-base.lucide class="h-7 w-7" icon="Building2" style="color: #1565c0;" />
                                            </div>
                                            <div>
                                                <div class="text-3xl font-extrabold leading-none" style="color: #1565c0;">{{ $totalInmuebles }}</div>
                                                <div class="mt-1 text-sm text-slate-500">Inmuebles</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Equipos --}}
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <a href="{{ route('gestion.equipos.index') }}" class="block">
                                <div @class([
                                    'relative zoom-in',
                                    'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                                ])>
                                    <div class="box p-5">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-14 w-14 items-center justify-center rounded-xl" style="background: #fff3e0;">
                                                <x-base.lucide class="h-7 w-7" icon="Settings" style="color: #ef6c00;" />
                                            </div>
                                            <div>
                                                <div class="text-3xl font-extrabold leading-none" style="color: #ef6c00;">{{ $totalEquipos }}</div>
                                                <div class="mt-1 text-sm text-slate-500">Equipos</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Mantenimientos Pendientes --}}
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <a href="{{ route('gestion.mantenimientos.index', ['estado' => 'programado']) }}" class="block">
                                <div @class([
                                    'relative zoom-in',
                                    'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                                ])>
                                    <div class="box p-5">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-14 w-14 items-center justify-center rounded-xl" style="background: #ffebee;">
                                                <x-base.lucide class="h-7 w-7" icon="Wrench" style="color: #c62828;" />
                                            </div>
                                            <div>
                                                <div class="text-3xl font-extrabold leading-none" style="color: #c62828;">{{ $mantPendientes }}</div>
                                                <div class="mt-1 text-sm text-slate-500">Mant. Pendientes</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Garantías Activas --}}
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <a href="{{ route('gestion.garantias.index', ['estado' => 'activa']) }}" class="block">
                                <div @class([
                                    'relative zoom-in',
                                    'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                                ])>
                                    <div class="box p-5">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-14 w-14 items-center justify-center rounded-xl" style="background: #e8f5e9;">
                                                <x-base.lucide class="h-7 w-7" icon="ShieldCheck" style="color: #2e7d32;" />
                                            </div>
                                            <div>
                                                <div class="text-3xl font-extrabold leading-none" style="color: #2e7d32;">{{ $garantiasActivas }}</div>
                                                <div class="mt-1 text-sm text-slate-500">Garantías Activas</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════
                     ALERTAS IMPORTANTES
                ═══════════════════════════════════════════════════════════ --}}
                <div class="col-span-12 mt-6">
                    <div class="intro-y box p-6">
                        <h5 class="mb-4 flex items-center text-lg font-bold" style="color: #1a3a5c;">
                            <x-base.lucide class="mr-2 h-5 w-5" icon="AlertTriangle" />
                            Alertas Importantes
                        </h5>
                        @if($alertas->isEmpty())
                            <p class="flex items-center text-sm text-slate-500">
                                <x-base.lucide class="mr-2 h-4 w-4 text-success" icon="CheckCircle" />
                                No hay alertas pendientes. ¡Todo está al día!
                            </p>
                        @else
                            <div class="space-y-2">
                                @foreach($alertas->take(8) as $alerta)
                                    <div class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm
                                        @if($alerta['tipo'] === 'danger') bg-danger/10 border-l-4 border-danger
                                        @elseif($alerta['tipo'] === 'warning') bg-warning/10 border-l-4 border-warning
                                        @elseif($alerta['tipo'] === 'info') bg-primary/10 border-l-4 border-primary
                                        @elseif($alerta['tipo'] === 'success') bg-success/10 border-l-4 border-success
                                        @endif
                                    ">
                                        <x-base.lucide class="h-4 w-4 flex-shrink-0
                                            @if($alerta['tipo'] === 'danger') text-danger
                                            @elseif($alerta['tipo'] === 'warning') text-warning
                                            @elseif($alerta['tipo'] === 'info') text-primary
                                            @elseif($alerta['tipo'] === 'success') text-success
                                            @endif
                                        " icon="{{ $alerta['icono'] }}" />
                                        <span class="flex-grow-1">{!! $alerta['texto'] !!}</span>
                                        <a href="{{ $alerta['link'] }}" class="ml-auto whitespace-nowrap text-xs font-bold text-primary hover:underline">
                                            Ver →
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════
                     GRÁFICOS - Fila 1
                ═══════════════════════════════════════════════════════════ --}}
                <div class="col-span-12 mt-6 lg:col-span-6">
                    <div class="intro-y box p-6">
                        <h5 class="mb-4 flex items-center text-lg font-bold" style="color: #1a3a5c;">
                            <x-base.lucide class="mr-2 h-5 w-5" icon="PieChart" />
                            Distribución por Tipo de Activo
                        </h5>
                        <div class="relative" style="height: 260px;">
                            <canvas id="chartTipoActivo"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 mt-6 lg:col-span-6">
                    <div class="intro-y box p-6">
                        <h5 class="mb-4 flex items-center text-lg font-bold" style="color: #1a3a5c;">
                            <x-base.lucide class="mr-2 h-5 w-5" icon="BarChart3" />
                            Estado de Mantenimientos
                        </h5>
                        <div class="relative" style="height: 260px;">
                            <canvas id="chartEstadoMant"></canvas>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════
                     GRÁFICOS - Fila 2
                ═══════════════════════════════════════════════════════════ --}}
                <div class="col-span-12 mt-6 lg:col-span-6">
                    <div class="intro-y box p-6">
                        <h5 class="mb-4 flex items-center text-lg font-bold" style="color: #1a3a5c;">
                            <x-base.lucide class="mr-2 h-5 w-5" icon="ShieldAlert" />
                            Equipos por Criticidad
                        </h5>
                        <div class="relative" style="height: 260px;">
                            <canvas id="chartCriticidad"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 mt-6 lg:col-span-6">
                    <div class="intro-y box p-6">
                        <h5 class="mb-4 flex items-center text-lg font-bold" style="color: #1a3a5c;">
                            <x-base.lucide class="mr-2 h-5 w-5" icon="Wrench" />
                            Mantenimientos por Tipo
                        </h5>
                        <div class="relative" style="height: 260px;">
                            <canvas id="chartMantTipo"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════
             COLUMNA DERECHA
        ═══════════════════════════════════════════════════════════════ --}}
        <div class="col-span-12 2xl:col-span-3">
            <div class="-mb-10 pb-10 2xl:border-l">
                <div class="grid grid-cols-12 gap-x-6 gap-y-6 2xl:gap-x-0 2xl:pl-6">

                    {{-- ─── Calendario de Mantenimientos ─── --}}
                    <div class="col-span-12 mt-3 md:col-span-6 xl:col-span-4 2xl:col-span-12 2xl:mt-8">
                        <div class="intro-x box p-5">
                            <h5 class="mb-4 flex items-center text-base font-bold" style="color: #1a3a5c;">
                                <x-base.lucide class="mr-2 h-5 w-5" icon="Calendar" />
                                Calendario de Mantenimientos
                            </h5>
                            <div id="calendarWidget"></div>
                            <div id="calDayEvents" class="mt-3"></div>
                        </div>
                    </div>

                    {{-- ─── Accesos Rápidos ─── --}}
                    <div class="col-span-12 mt-3 md:col-span-6 xl:col-span-4 2xl:col-span-12">
                        <div class="intro-x box p-5">
                            <h5 class="mb-4 flex items-center text-base font-bold" style="color: #1a3a5c;">
                                <x-base.lucide class="mr-2 h-5 w-5" icon="Zap" />
                                Accesos Rápidos
                            </h5>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('gestion.inmuebles.create') }}"
                                   class="flex items-center gap-3 rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition-all hover:border-primary hover:bg-slate-50 hover:translate-x-1 dark:border-darkmode-400 dark:text-slate-300 dark:hover:bg-darkmode-400">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg" style="background: #e3f2fd;">
                                        <x-base.lucide class="h-5 w-5" icon="PlusCircle" style="color: #1565c0;" />
                                    </div>
                                    Registrar Nuevo Inmueble
                                </a>
                                <a href="{{ route('gestion.mantenimientos.create') }}"
                                   class="flex items-center gap-3 rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition-all hover:border-primary hover:bg-slate-50 hover:translate-x-1 dark:border-darkmode-400 dark:text-slate-300 dark:hover:bg-darkmode-400">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg" style="background: #fff3e0;">
                                        <x-base.lucide class="h-5 w-5" icon="Wrench" style="color: #ef6c00;" />
                                    </div>
                                    Registrar Mantenimiento
                                </a>
                                <a href="{{ route('gestion.garantias.create') }}"
                                   class="flex items-center gap-3 rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition-all hover:border-primary hover:bg-slate-50 hover:translate-x-1 dark:border-darkmode-400 dark:text-slate-300 dark:hover:bg-darkmode-400">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg" style="background: #e8f5e9;">
                                        <x-base.lucide class="h-5 w-5" icon="ShieldPlus" style="color: #2e7d32;" />
                                    </div>
                                    Solicitar Garantía
                                </a>
                                <a href="{{ route('gestion.equipos.create') }}"
                                   class="flex items-center gap-3 rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition-all hover:border-primary hover:bg-slate-50 hover:translate-x-1 dark:border-darkmode-400 dark:text-slate-300 dark:hover:bg-darkmode-400">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg" style="background: #fce4ec;">
                                        <x-base.lucide class="h-5 w-5" icon="Link" style="color: #ad1457;" />
                                    </div>
                                    Registrar Equipo
                                </a>
                                <a href="{{ route('gestion.equipos.index') }}"
                                   class="flex items-center gap-3 rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition-all hover:border-primary hover:bg-slate-50 hover:translate-x-1 dark:border-darkmode-400 dark:text-slate-300 dark:hover:bg-darkmode-400">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg" style="background: #fff9c4;">
                                        <x-base.lucide class="h-5 w-5" icon="Settings" style="color: #f57f17;" />
                                    </div>
                                    Inventario de Equipos
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="mt-6 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} Zona Franca Palmaseca — Sistema de Gestión de Inventario de Infraestructura Física
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ─── Gráfico: Distribución por Tipo de Activo (Doughnut) ───
    const tipoLabels = @json($inmueblesPorTipo->pluck('label'));
    const tipoValues = @json($inmueblesPorTipo->pluck('value'));
    const tipoColors = ['#1565c0','#2e7d32','#ef6c00','#7b1fa2','#c62828','#00838f','#ad1457','#4e342e','#37474f','#1b5e20','#e65100','#283593'];

    if (document.getElementById('chartTipoActivo')) {
        new Chart(document.getElementById('chartTipoActivo'), {
            type: 'doughnut',
            data: {
                labels: tipoLabels,
                datasets: [{
                    data: tipoValues,
                    backgroundColor: tipoColors.slice(0, tipoLabels.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 8 } }
                }
            }
        });
    }

    // ─── Gráfico: Estado de Mantenimientos (Bar) ───
    const estadosMant = @json($estadosMantenimiento);
    const estadoLabels = {
        'programado': 'Programado',
        'en_proceso': 'En Proceso',
        'completado': 'Completado',
        'cancelado': 'Cancelado'
    };
    const estadoColores = {
        'programado': '#1565c0',
        'en_proceso': '#ef6c00',
        'completado': '#2e7d32',
        'cancelado': '#c62828'
    };

    if (document.getElementById('chartEstadoMant')) {
        new Chart(document.getElementById('chartEstadoMant'), {
            type: 'bar',
            data: {
                labels: Object.keys(estadosMant).map(k => estadoLabels[k] || k),
                datasets: [{
                    label: 'Cantidad',
                    data: Object.values(estadosMant),
                    backgroundColor: Object.keys(estadosMant).map(k => estadoColores[k] || '#6c757d'),
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // ─── Gráfico: Equipos por Criticidad (Doughnut) ───
    const critLabels = @json($equiposPorCriticidad->pluck('label'));
    const critValues = @json($equiposPorCriticidad->pluck('value'));
    const critColors = @json($equiposPorCriticidad->pluck('color'));

    if (document.getElementById('chartCriticidad')) {
        new Chart(document.getElementById('chartCriticidad'), {
            type: 'doughnut',
            data: {
                labels: critLabels,
                datasets: [{
                    data: critValues,
                    backgroundColor: critColors.length ? critColors : ['#c62828','#ef6c00','#f9a825','#2e7d32'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 8 } }
                }
            }
        });
    }

    // ─── Gráfico: Mantenimientos por Tipo (Bar horizontal) ───
    const mantTipo = @json($mantPorTipo);
    const mantTipoLabels = {
        'preventivo': 'Preventivo',
        'correctivo': 'Correctivo',
        'predictivo': 'Predictivo'
    };
    const mantTipoColores = {
        'preventivo': '#2e7d32',
        'correctivo': '#c62828',
        'predictivo': '#1565c0'
    };

    if (document.getElementById('chartMantTipo')) {
        new Chart(document.getElementById('chartMantTipo'), {
            type: 'bar',
            data: {
                labels: Object.keys(mantTipo).map(k => mantTipoLabels[k] || k),
                datasets: [{
                    label: 'Cantidad',
                    data: Object.values(mantTipo),
                    backgroundColor: Object.keys(mantTipo).map(k => mantTipoColores[k] || '#6c757d'),
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, ticks: { stepSize: 1 } },
                    y: { grid: { display: false } }
                }
            }
        });
    }

    // ─── Calendario de Mantenimientos ───
    const fechasConEventos = @json($fechasConEventos);
    const today = new Date('{{ $today->format("Y-m-d") }}T00:00:00');

    renderCalendar(today.getFullYear(), today.getMonth());

    function renderCalendar(year, month) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDow = firstDay.getDay();
        const daysInMonth = lastDay.getDate();
        const monthName = firstDay.toLocaleDateString('es-CO', { month: 'long', year: 'numeric' });

        const maintDates = new Set();
        fechasConEventos.forEach(f => {
            const d = new Date(f + 'T00:00:00');
            if (d.getMonth() === month && d.getFullYear() === year) maintDates.add(d.getDate());
        });

        let html = `<div class="flex items-center justify-between mb-3">
            <button class="btn btn-sm border-slate-300 px-2 dark:border-darkmode-400" onclick="window._renderCal(${month === 0 ? year - 1 : year},${month === 0 ? 11 : month - 1})">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <strong class="capitalize text-sm">${monthName}</strong>
            <button class="btn btn-sm border-slate-300 px-2 dark:border-darkmode-400" onclick="window._renderCal(${month === 11 ? year + 1 : year},${month === 11 ? 0 : month + 1})">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>`;

        html += '<div class="grid grid-cols-7 gap-1 text-center text-xs">';
        ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'].forEach(d => {
            html += `<div class="font-bold py-1" style="color:#1a3a5c;">${d}</div>`;
        });

        for (let i = 0; i < startDow; i++) html += '<div class="py-1 text-slate-300"></div>';
        for (let d = 1; d <= daysInMonth; d++) {
            const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
            const hasEvent = maintDates.has(d);
            const cls = isToday
                ? 'bg-primary text-white font-bold rounded-full'
                : (hasEvent ? 'bg-pending/20 rounded cursor-pointer hover:bg-primary/10' : 'rounded cursor-pointer hover:bg-slate-100');
            const dot = hasEvent && !isToday ? '<div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-warning"></div>' : '';
            html += `<div class="relative py-1 ${cls}" onclick="window._showDayEvents(${year},${month},${d})">${d}${dot}</div>`;
        }
        html += '</div>';
        document.getElementById('calendarWidget').innerHTML = html;
    }

    window._renderCal = renderCalendar;

    window._showDayEvents = function(y, m, d) {
        const dateStr = `${y}-${String(m+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const el = document.getElementById('calDayEvents');
        el.innerHTML = '<p class="text-center text-xs text-slate-400">Cargando...</p>';

        fetch(`{{ url('/dashboard/mantenimientos-dia') }}?fecha=${dateStr}`)
            .then(r => r.json())
            .then(data => {
                if (!data.length) {
                    el.innerHTML = `<p class="text-xs text-slate-500">Sin mantenimientos para el ${d}/${m+1}/${y}</p>`;
                    return;
                }
                el.innerHTML = data.map(e =>
                    `<div class="flex items-center gap-2 rounded-lg bg-primary/10 border-l-4 border-primary px-3 py-2 mb-1 text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                        <span><strong>${e.codigo}</strong> — ${e.activo} (${e.tipo})</span>
                        <a href="${e.link}" class="ml-auto text-primary font-bold hover:underline">Ver</a>
                    </div>`
                ).join('');
            })
            .catch(() => {
                el.innerHTML = `<p class="text-xs text-slate-500">Sin mantenimientos para el ${d}/${m+1}/${y}</p>`;
            });
    };
});
</script>
@endpush
