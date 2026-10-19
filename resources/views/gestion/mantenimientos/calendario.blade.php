@extends('../layouts/' . $layout)

@section('subhead')
    <title>Calendario de Mantenimientos - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col items-center sm:flex-row">
        <h2 class="mr-auto text-lg font-medium">Calendario de Mantenimientos</h2>
        <div class="mt-4 flex w-full sm:mt-0 sm:w-auto">
            <x-base.button class="mr-2 shadow-md" type="button" onclick="window.print()">
                <x-base.lucide class="mr-2 h-4 w-4" icon="Printer" /> Imprimir
            </x-base.button>
            <a href="{{ route('gestion.mantenimientos.create') }}">
                <x-base.button class="shadow-md" variant="primary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="Plus" /> Programar
                </x-base.button>
            </a>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-5">
        <!-- BEGIN: Calendar Side Menu -->
        <div class="col-span-12 xl:col-span-4 2xl:col-span-3 print:hidden">

            {{-- ─── Resumen ─── --}}
            <div class="box intro-y p-5">
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="rounded-md bg-primary/10 p-3">
                        <div class="text-2xl font-medium text-primary">{{ $totalMes }}</div>
                        <div class="mt-0.5 text-xs text-slate-500">Este mes</div>
                    </div>
                    <div class="rounded-md bg-danger/10 p-3">
                        <div class="text-2xl font-medium text-danger">{{ $totalVencidos }}</div>
                        <div class="mt-0.5 text-xs text-slate-500">Vencidos</div>
                    </div>
                </div>

                {{-- ─── Filtros ─── --}}
                <div class="mt-5 border-t border-slate-200/60 pt-5 dark:border-darkmode-400">
                    <div class="mb-3 font-medium">Filtros</div>
                    <x-base.form-select class="w-full" id="filtro-tipo-mantenimiento">
                        <option value="">Todos los tipos</option>
                        <option value="preventivo">Preventivo</option>
                        <option value="correctivo">Correctivo</option>
                        <option value="predictivo">Predictivo</option>
                    </x-base.form-select>
                    <x-base.form-select class="mt-3 w-full" id="filtro-estado">
                        <option value="">Todos los estados</option>
                        <option value="programado">Programado</option>
                        <option value="en_proceso">En Proceso</option>
                        <option value="completado">Completado</option>
                        <option value="cancelado">Cancelado</option>
                    </x-base.form-select>
                    <x-base.form-select class="mt-3 w-full" id="filtro-tipo-activo">
                        <option value="">Inmuebles y equipos</option>
                        <option value="inmueble">Inmuebles</option>
                        <option value="equipo">Equipos</option>
                    </x-base.form-select>
                </div>

                {{-- ─── Leyenda ─── --}}
                <div class="mt-5 border-t border-slate-200/60 pt-5 dark:border-darkmode-400">
                    <div class="mb-3 font-medium">Convenciones</div>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="flex items-center"><div class="mr-2 h-2 w-2 rounded-full bg-primary"></div>Programado</div>
                        <div class="flex items-center"><div class="mr-2 h-2 w-2 rounded-full bg-warning"></div>En proceso</div>
                        <div class="flex items-center"><div class="mr-2 h-2 w-2 rounded-full bg-success"></div>Completado</div>
                        <div class="flex items-center"><div class="mr-2 h-2 w-2 rounded-full bg-slate-400"></div>Cancelado</div>
                        <div class="flex items-center"><div class="mr-2 h-2 w-2 rounded-full bg-danger"></div>Vencido</div>
                    </div>
                </div>
            </div>

            {{-- ─── Próximos 30 días ─── --}}
            <div class="box intro-y mt-5 p-5">
                <div class="font-medium">Próximos 30 días</div>
                <div class="mt-3 border-t border-slate-200/60 py-3 dark:border-darkmode-400">
                    @forelse ($proximos as $m)
                        <a href="{{ route('gestion.mantenimientos.show', $m) }}"
                            class="-mx-3 flex items-center rounded-md p-3 transition duration-300 ease-in-out hover:bg-slate-100 dark:hover:bg-darkmode-400">
                            <div class="mr-3 h-2 w-2 flex-none rounded-full {{ $m->estado === 'en_proceso' ? 'bg-warning' : 'bg-primary' }}"></div>
                            <div class="min-w-0 flex-1">
                                <div class="truncate">{{ $m->codigo }} · {{ $m->nombre_activo }}</div>
                                <div class="mt-0.5 text-xs text-slate-500">
                                    {{ ucfirst($m->tipo_mantenimiento) }}
                                    <span class="mx-1">•</span>
                                    {{ $m->fecha_programada->isToday() ? 'Hoy' : $m->fecha_programada->format('d/m/Y') }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-3 text-center text-slate-500">Sin mantenimientos próximos</div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- END: Calendar Side Menu -->

        <!-- BEGIN: Calendar Content -->
        <div class="col-span-12 xl:col-span-8 2xl:col-span-9 print:col-span-12">
            <div class="box p-5">
                <div id="calendario-mantenimientos"></div>
            </div>
        </div>
        <!-- END: Calendar Content -->
    </div>
@endsection

@push('styles')
    <style>
        #calendario-mantenimientos .evento-mant { cursor: pointer; border: 0; padding: 1px 4px; }
        #calendario-mantenimientos .evento-mant .fc-event-title,
        #calendario-mantenimientos .evento-mant .fc-event-time { color: #fff; }
        #calendario-mantenimientos .evento-mant--programado { background-color: rgb(var(--color-primary)); }
        #calendario-mantenimientos .evento-mant--en_proceso { background-color: rgb(var(--color-warning)); }
        #calendario-mantenimientos .evento-mant--completado { background-color: rgb(var(--color-success)); }
        #calendario-mantenimientos .evento-mant--cancelado  { background-color: rgb(148 163 184); text-decoration: line-through; }
        #calendario-mantenimientos .evento-mant--vencido    { background-color: rgb(var(--color-danger)); }
        /* En la vista de lista FullCalendar pinta un punto en vez de fondo */
        #calendario-mantenimientos .fc-list-event.evento-mant { background-color: transparent; }
        #calendario-mantenimientos .fc-list-event.evento-mant .fc-event-title { color: inherit; }
    </style>
@endpush

@push('vendors')
    @vite('resources/js/vendor/calendar/index.js')
    @vite('resources/js/vendor/calendar/plugins/interaction.js')
    @vite('resources/js/vendor/calendar/plugins/day-grid.js')
    @vite('resources/js/vendor/calendar/plugins/time-grid.js')
    @vite('resources/js/vendor/calendar/plugins/list.js')
@endpush

@push('scripts')
    {{-- type="module" para que se ejecute después de los módulos de FullCalendar --}}
    <script type="module">
        const COLORES_LISTA = {
            programado: 'rgb(var(--color-primary))',
            en_proceso: 'rgb(var(--color-warning))',
            completado: 'rgb(var(--color-success))',
            cancelado:  'rgb(148 163 184)',
            vencido:    'rgb(var(--color-danger))',
        };

        const filtros = {
            tipo_mantenimiento: document.getElementById('filtro-tipo-mantenimiento'),
            estado:             document.getElementById('filtro-estado'),
            tipo_activo:        document.getElementById('filtro-tipo-activo'),
        };

        const calendario = new Calendar(document.getElementById('calendario-mantenimientos'), {
            plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
            locale: {
                code: 'es',
                week: { dow: 1, doy: 4 },
                buttonText: { prev: 'Ant', next: 'Sig', today: 'Hoy', month: 'Mes', week: 'Semana', day: 'Día', list: 'Agenda' },
                allDayText: 'Todo el día',
                moreLinkText: n => `+${n} más`,
                noEventsText: 'No hay mantenimientos para mostrar',
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth',
            },
            initialView: 'dayGridMonth',
            navLinks: true,
            editable: false,
            dayMaxEvents: true,
            events: {
                url: @json(route('gestion.mantenimientos.calendario-eventos')),
                extraParams: () => Object.fromEntries(
                    Object.entries(filtros).map(([clave, el]) => [clave, el.value])
                ),
            },
            eventDidMount: info => {
                const p = info.event.extendedProps;
                const estado = p.vencido ? 'vencido' : p.estado;

                const dot = info.el.querySelector('.fc-list-event-dot');
                if (dot) dot.style.borderColor = COLORES_LISTA[estado];

                info.el.title = [
                    info.event.title,
                    `Tipo: ${p.tipo}`,
                    `Estado: ${p.estado.replace('_', ' ')}${p.vencido ? ' (vencido)' : ''}`,
                    p.criticidad ? `Criticidad: ${p.criticidad}` : null,
                    p.responsable ? `Responsable: ${p.responsable}` : null,
                    p.descripcion,
                ].filter(Boolean).join('\n');
            },
        });

        calendario.render();

        Object.values(filtros).forEach(el => el.addEventListener('change', () => calendario.refetchEvents()));
    </script>
@endpush
