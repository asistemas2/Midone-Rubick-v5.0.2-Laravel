@extends('../layouts/' . $layout)

@section('subhead')
    <title>Presupuesto y Ejecución de Mantenimientos {{ $anio }} - ZFP</title>
@endsection

@section('subcontent')
    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    {{-- ENCABEZADO                                                          --}}
    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    <div class="intro-y mt-8 flex flex-col items-center sm:flex-row">
        <div>
            <h2 class="text-lg font-medium">Presupuesto y Ejecución de Mantenimientos</h2>
            <p class="mt-1 text-sm text-slate-500">
                Análisis comparativo entre el <strong>presupuesto aprobado</strong> (programados)
                y el <strong>costo real</strong> (completados).
            </p>
        </div>
        <div class="mt-4 flex w-full sm:mt-0 sm:w-auto">
            <x-base.button class="mr-2 shadow-md" variant="primary" onclick="window.print()">
                <x-base.lucide class="mr-2 h-4 w-4" icon="Printer" /> Imprimir
            </x-base.button>
            <x-base.button class="shadow-md" variant="outline-secondary">
                <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Exportar PDF
            </x-base.button>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    {{-- FILTROS                                                             --}}
    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    <div class="intro-y box mt-5 p-5">
        <form action="{{ route('gestion.mantenimientos.presupuesto') }}" method="GET" class="grid grid-cols-12 gap-4">
            <div class="col-span-12 sm:col-span-3">
                <x-base.form-label for="anio">Año</x-base.form-label>
                <x-base.form-select id="anio" name="anio" onchange="this.form.submit()">
                    @foreach ($aniosDisponibles as $a)
                        <option value="{{ $a }}" {{ $anio == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </x-base.form-select>
            </div>
            <div class="col-span-12 sm:col-span-3">
                <x-base.form-label for="tipo_activo">Tipo de Activo</x-base.form-label>
                <x-base.form-select id="tipo_activo" name="tipo_activo" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    <option value="inmueble" {{ $tipoActivo == 'inmueble' ? 'selected' : '' }}>Inmuebles</option>
                    <option value="equipo" {{ $tipoActivo == 'equipo' ? 'selected' : '' }}>Equipos</option>
                </x-base.form-select>
            </div>
            <div class="col-span-12 sm:col-span-3">
                <x-base.form-label for="tipo_mantenimiento">Tipo de Mantenimiento</x-base.form-label>
                <x-base.form-select id="tipo_mantenimiento" name="tipo_mantenimiento" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    <option value="preventivo" {{ $tipoMantenimiento == 'preventivo' ? 'selected' : '' }}>Preventivo
                    </option>
                    <option value="correctivo" {{ $tipoMantenimiento == 'correctivo' ? 'selected' : '' }}>Correctivo
                    </option>
                    <option value="predictivo" {{ $tipoMantenimiento == 'predictivo' ? 'selected' : '' }}>Predictivo
                    </option>
                </x-base.form-select>
            </div>
            <div class="col-span-12 sm:col-span-3">
                <x-base.form-label for="tipo_responsable">Responsable</x-base.form-label>
                <x-base.form-select id="tipo_responsable" name="tipo_responsable" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    @foreach ($responsablesDisponibles as $r)
                        <option value="{{ $r }}" {{ $tipoResponsable == $r ? 'selected' : '' }}>
                            {{ $r }}</option>
                    @endforeach
                </x-base.form-select>
            </div>
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    {{-- PESTAÑAS (x-base.tab)                                                --}}
    {{-- ═══════════════════════════════════════════════════════════════════ --}}
    <div class="intro-y mt-5">
        <x-base.tab.group>
            <x-base.tab.list variant="boxed-tabs">
                {{-- Pestaña 1: Presupuesto Aprobado --}}
                <x-base.tab id="presupuesto" selected>
                    <x-base.tab.button>
                        Presupuesto Aprobado
                        <span class="ml-2 rounded-full bg-primary/10 px-2 py-0.5 text-xs text-success">
                            ${{ number_format($totalAnualPresupuesto, 0, ',', '.') }}
                        </span>
                    </x-base.tab.button>
                </x-base.tab>

                {{-- Pestaña 2: Ejecutado Real --}}
                <x-base.tab id="ejecutado">
                    <x-base.tab.button>
                        Ejecutado Real
                        <span class="ml-2 rounded-full bg-success/10 px-2 py-0.5 text-xs text-success">
                            ${{ number_format($totalAnualEjecutado, 0, ',', '.') }}
                        </span>
                    </x-base.tab.button>
                </x-base.tab>

                {{-- Pestaña 3: Cumplimiento Presupuestal --}}
                @php $desviacionTotal = $totalAnualEjecutado - $totalAnualPresupuesto; @endphp
                <x-base.tab id="comparativa">
                    <x-base.tab.button>
                        Cumplimiento Presupuestal
                        <span
                            class="ml-2 rounded-full {{ $desviacionTotal >= 0 ? 'bg-danger/10 text-danger' : 'bg-success/10 text-success' }} px-2 py-0.5 text-xs">
                            {{ $desviacionTotal >= 0 ? '+' : '' }}${{ number_format($desviacionTotal, 0, ',', '.') }}
                        </span>
                    </x-base.tab.button>
                </x-base.tab>
            </x-base.tab.list>

            <x-base.tab.panels>
                <x-base.tab.panel id="presupuesto" selected>
                    @include('gestion.mantenimientos.partials._presupuesto_aprobado')
                </x-base.tab.panel>

                <x-base.tab.panel id="ejecutado">
                    @include('gestion.mantenimientos.partials._presupuesto_real')
                </x-base.tab.panel>

                <x-base.tab.panel id="comparativa">
                    @include('gestion.mantenimientos.partials._presupuesto_comparativa')
                </x-base.tab.panel>
            </x-base.tab.panels>
        </x-base.tab.group>
    </div>
@endsection
