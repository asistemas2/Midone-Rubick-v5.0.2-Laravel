@extends('../layouts/' . $layout)

@section('subhead')
    <title>{{ $mantenimiento->codigo }} - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Detalle del Mantenimiento</h2>

        @if($mantenimiento->estado !== 'completado' && $mantenimiento->estado !== 'cancelado')
            <x-base.button
                class="mr-2 shadow-md"
                data-tw-toggle="modal"
                data-tw-target="#completar-mantenimiento-modal"
                variant="success"
            >
                <x-base.lucide class="mr-2 h-4 w-4" icon="CheckCircle" /> Completar Mantenimiento
            </x-base.button>
        @endif

        <a href="{{ route('gestion.mantenimientos.edit', $mantenimiento) }}">
            <x-base.button class="mr-2 shadow-md" variant="primary">
                <x-base.lucide class="mr-2 h-4 w-4" icon="Edit" /> Editar
            </x-base.button>
        </a>
        <a href="{{ route('gestion.mantenimientos.index') }}">
            <x-base.button variant="outline-secondary">
                <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft" /> Volver
            </x-base.button>
        </a>
    </div>

    @if (session('success'))
        <div class="intro-y mt-5 rounded-md bg-success/20 px-5 py-3 text-success">
            <x-base.lucide class="mr-2 inline h-4 w-4" icon="CheckCircle" /> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="intro-y mt-5 rounded-md bg-danger/20 px-5 py-3 text-danger">
            <x-base.lucide class="mr-2 inline h-4 w-4" icon="XCircle" /> {{ session('error') }}
        </div>
    @endif

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">

            {{-- BLOQUE 1: DETALLE DEL MANTENIMIENTO --}}
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
                        <div class="text-xs text-slate-500">Criterio Mantenimiento</div>
                        <div class="mt-1">{!! $mantenimiento->criterio_mantenimiento_badge !!}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Criticidad</div>
                        <div class="mt-1">{!! $mantenimiento->criticidad_mantenimiento_badge !!}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Presupuesto Aprobado</div>
                        <div class="mt-1 font-medium">
                            @if($mantenimiento->presupuesto_aprobado)
                                ${{ number_format($mantenimiento->presupuesto_aprobado, 2, ',', '.') }}
                            @else
                                —
                            @endif
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Costo Real</div>
                        <div class="mt-1 font-medium">
                            @if($mantenimiento->costo_real)
                                ${{ number_format($mantenimiento->costo_real, 2, ',', '.') }}
                            @else
                                —
                            @endif
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Periodicidad</div>
                        <div class="mt-1 font-medium">{{ $mantenimiento->periodicidadMantenimiento?->nombre ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Fecha Programada</div>
                        <div class="mt-1 font-medium">{{ $mantenimiento->fecha_programada?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Fecha Realizada</div>
                        <div class="mt-1 font-medium">{{ $mantenimiento->fecha_realizada?->format('d/m/Y') ?? '—' }}</div>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <div class="text-xs text-slate-500">Fecha Completado</div>
                        <div class="mt-1 font-medium">{{ $mantenimiento->fecha_completado?->format('d/m/Y H:i') ?? '—' }}</div>
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

            {{-- BLOQUE 2: HISTORIAL DE CAMBIOS --}}
            <div class="intro-y box mt-5 p-5">
                <div class="mb-3 flex items-center border-b border-slate-200/60 pb-3 dark:border-darkmode-400">
                    <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="History" />
                    <span class="text-base font-medium">Historial de Cambios ({{ $mantenimiento->historial->count() }})</span>
                </div>

                @if($mantenimiento->historial->count())
                    <div class="relative mt-5">
                        <div class="absolute left-4 top-0 h-full w-px bg-slate-200 dark:bg-darkmode-400"></div>

                        <div class="space-y-5">
                            @foreach($mantenimiento->historial as $h)
                                <div class="relative flex gap-4">
                                    <div class="relative z-10 flex h-8 w-8 flex-none items-center justify-center rounded-full bg-primary/10 text-primary">
                                        <x-base.lucide class="h-4 w-4" icon="Circle" />
                                    </div>

                                    <div class="flex-1 rounded-md border border-slate-200/60 p-3 dark:border-darkmode-400">
                                        <div class="flex flex-wrap items-center gap-2">
                                            {!! $h->estado_anterior_badge !!}
                                            <x-base.lucide class="h-3 w-3 text-slate-400" icon="ArrowRight" />
                                            {!! $h->estado_nuevo_badge !!}
                                            <span class="ml-auto text-xs text-slate-500">{{ $h->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <div class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                                            <strong>{{ $h->responsable_nombre }}</strong>
                                            @if($h->comentario)
                                                <span class="text-slate-500"> — {{ $h->comentario }}</span>
                                            @endif
                                        </div>
                                        @if($h->costo_real)
                                            <div class="mt-1 text-xs text-slate-500">
                                                Costo real registrado: <strong>${{ number_format($h->costo_real, 2) }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="py-4 text-center text-sm text-slate-500">Sin cambios registrados.</div>
                @endif
            </div>

            {{-- BLOQUE 3: DOCUMENTOS ADJUNTOS --}}
            <div class="intro-y box mt-5 p-5">
                <div class="mb-3 flex items-center border-b border-slate-200/60 pb-3 dark:border-darkmode-400">
                    <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="FolderOpen" />
                    <span class="text-base font-medium">Documentos Adjuntos ({{ $mantenimiento->documentos->count() }})</span>
                </div>

                @if($mantenimiento->documentos->count())
                    <x-base.table class="border-separate border-spacing-y-[10px]">
                        <x-base.table.thead>
                            <x-base.table.tr>
                                <x-base.table.th class="border-b-0">TIPO</x-base.table.th>
                                <x-base.table.th class="border-b-0">NOMBRE</x-base.table.th>
                                <x-base.table.th class="border-b-0">TAMAÑO</x-base.table.th>
                                <x-base.table.th class="border-b-0">SUBIÓ</x-base.table.th>
                                <x-base.table.th class="border-b-0 text-center">ACCIONES</x-base.table.th>
                            </x-base.table.tr>
                        </x-base.table.thead>
                        <x-base.table.tbody>
                            @foreach($mantenimiento->documentos as $doc)
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">
                                        <span class="rounded bg-primary/10 px-2 py-1 text-xs text-primary">{{ $doc->tipo_legible }}</span>
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">
                                        {{ $doc->nombre_original }}
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">
                                        {{ $doc->tamano_legible }}
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">
                                        {{ $doc->user?->full_name ?? 'Sistema' }}
                                        <div class="text-xs text-slate-500">{{ $doc->created_at->format('d/m/Y H:i') }}</div>
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b-0 bg-white text-center dark:bg-darkmode-600">
                                        <a href="{{ Storage::disk('public')->url($doc->ruta) }}" target="_blank" class="text-primary">
                                            <x-base.lucide class="h-4 w-4" icon="Download" />
                                        </a>
                                    </x-base.table.td>
                                </x-base.table.tr>
                            @endforeach
                        </x-base.table.tbody>
                    </x-base.table>
                @else
                    <div class="py-4 text-center text-sm text-slate-500">Sin documentos adjuntos.</div>
                @endif
            </div>

            {{-- BLOQUE 4: GARANTÍAS --}}
            @if($mantenimiento->garantias->count())
            <div class="intro-y box mt-5 p-5">
                <div class="mb-3 flex items-center border-b border-slate-200/60 pb-3 dark:border-darkmode-400">
                    <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="ShieldCheck" />
                    <span class="text-base font-medium">Garantías ({{ $mantenimiento->garantias->count() }})</span>
                </div>
                <x-base.table class="border-separate border-spacing-y-[10px]">
                    <x-base.table.thead>
                        <x-base.table.tr>
                            <x-base.table.th class="border-b-0">CÓDIGO</x-base.table.th>
                            <x-base.table.th class="border-b-0">PROVEEDOR</x-base.table.th>
                            <x-base.table.th class="border-b-0">VIGENCIA</x-base.table.th>
                            <x-base.table.th class="border-b-0">ESTADO</x-base.table.th>
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

    {{-- MODAL DE COMPLETAR MANTENIMIENTO --}}
    @if($mantenimiento->estado !== 'completado' && $mantenimiento->estado !== 'cancelado')
        <x-base.dialog id="completar-mantenimiento-modal" size="lg">
            <x-base.dialog.panel>
                <form action="{{ route('gestion.mantenimientos.completar', $mantenimiento) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <x-base.dialog.title>
                        <h2 class="mr-auto text-base font-medium">
                            Completar Mantenimiento
                        </h2>
                        <a class="absolute top-0 right-0 mt-3 mr-3" data-tw-dismiss="modal" href="#">
                            <x-base.lucide class="h-8 w-8 text-slate-400" icon="X" />
                        </a>
                    </x-base.dialog.title>

                    <x-base.dialog.description class="space-y-4">
                        @if ($errors->any())
                            <div class="rounded-md bg-danger/20 px-4 py-3 text-sm text-danger">
                                <div class="font-medium">Revise los datos:</div>
                                <ul class="mt-1 list-inside list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Costo real --}}
                        <div>
                            <x-base.form-label for="costo_real">
                                <div class="text-left">
                                    <div class="font-medium">Costo Real <span class="text-danger">*</span></div>
                                    <div class="mt-1 text-xs text-slate-500">Valor final ejecutado.</div>
                                </div>
                            </x-base.form-label>
                            <x-base.input-group class="mt-2" inputGroup>
                                <x-base.input-group.text>$</x-base.input-group.text>
                                <x-base.form-input class="w-full" name="costo_real" id="costo_real" type="number" step="0.01" min="0" value="{{ old('costo_real', $mantenimiento->presupuesto_aprobado) }}" placeholder="0.00" required />
                            </x-base.input-group>
                        </div>

                        {{-- Comentario --}}
                        <div>
                            <x-base.form-label for="comentario">
                                <div class="text-left">
                                    <div class="font-medium">Comentario</div>
                                </div>
                            </x-base.form-label>
                            <x-base.form-textarea class="mt-2 w-full" name="comentario" id="comentario" rows="2" placeholder="Observaciones al completar...">{{ old('comentario') }}</x-base.form-textarea>
                        </div>

                        {{-- Documentos --}}
                        <div>
                            <x-base.form-label for="documentos">
                                <div class="text-left">
                                    <div class="font-medium">Documentos</div>
                                    <div class="mt-1 text-xs text-slate-500">Orden de compra, facturas, evidencias, etc.</div>
                                </div>
                            </x-base.form-label>
                            <x-base.form-input class="mt-2 w-full" name="documentos[]" id="documentos" type="file" multiple />
                        </div>

                        {{-- Tipos de documentos (multi-select tipo tarjetas) --}}
                        <div>
                            <x-base.form-label>
                                <div class="text-left">
                                    <div class="font-medium">Tipos de documentos</div>
                                    <div class="mt-1 text-xs text-slate-500">
                                        Seleccione los tipos en el orden en que subió los archivos.
                                    </div>
                                </div>
                            </x-base.form-label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach([
                                    'orden_compra' => 'Orden de Compra',
                                    'factura' => 'Factura',
                                    'evidencia_fotografica' => 'Evidencia Fotográfica',
                                    'acta' => 'Acta',
                                    'otro' => 'Otro',
                                ] as $value => $label)
                                    <label
                                        for="tipo-doc-{{ $value }}"
                                        class="inline-flex cursor-pointer items-center gap-2 rounded-md border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:border-primary hover:text-primary has-[:checked]:border-primary has-[:checked]:bg-primary/5 has-[:checked]:text-primary dark:border-darkmode-400 dark:bg-darkmode-600 dark:text-slate-300 dark:has-[:checked]:bg-primary/10"
                                    >
                                        <input
                                            type="checkbox"
                                            id="tipo-doc-{{ $value }}"
                                            name="tipos_documentos[]"
                                            value="{{ $value }}"
                                            class="hidden"
                                        />
                                        <span>{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Separador --}}
                        <div class="border-t border-slate-200/60 pt-4 dark:border-darkmode-400">
                            <label
                                for="programar_nuevo"
                                class="inline-flex cursor-pointer items-center gap-2 text-sm text-slate-700 dark:text-slate-300"
                            >
                                <input
                                    type="checkbox"
                                    id="programar_nuevo"
                                    name="programar_nuevo"
                                    value="1"
                                    class="form-check-input"
                                    onchange="toggleSeccion('wrapper-nuevo-mantenimiento', this.checked)"
                                    {{ old('programar_nuevo') ? 'checked' : '' }}
                                />
                                <span class="font-medium">Programar nuevo mantenimiento</span>
                                <span class="ml-1 text-xs text-slate-500">(opcional)</span>
                            </label>
                        </div>

                        {{-- Bloque para programar nuevo mantenimiento --}}
                        <div id="wrapper-nuevo-mantenimiento" class="space-y-3 rounded-md border border-slate-200/60 p-3 dark:border-darkmode-400" style="display: {{ old('programar_nuevo') ? 'block' : 'none' }};">
                            <div class="grid grid-cols-12 gap-3">
                                <div class="col-span-12 sm:col-span-4">
                                    <x-base.form-label for="nuevo_tipo_mantenimiento" class="text-xs">Tipo</x-base.form-label>
                                    <x-base.form-select class="w-full" id="nuevo_tipo_mantenimiento" name="nuevo_tipo_mantenimiento">
                                        @foreach (['preventivo' => 'Preventivo', 'correctivo' => 'Correctivo', 'predictivo' => 'Predictivo'] as $valor => $etiqueta)
                                            <option value="{{ $valor }}" {{ old('nuevo_tipo_mantenimiento', $mantenimiento->tipo_mantenimiento) === $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                                <div class="col-span-12 sm:col-span-4">
                                    <x-base.form-label for="nuevo_fecha_programada" class="text-xs">Fecha Programada <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-input class="w-full" id="nuevo_fecha_programada" name="nuevo_fecha_programada" type="date" value="{{ old('nuevo_fecha_programada') }}" />
                                </div>
                                <div class="col-span-12 sm:col-span-4">
                                    <x-base.form-label for="nuevo_periodicidad_id" class="text-xs">Periodicidad</x-base.form-label>
                                    <x-base.form-select class="w-full" id="nuevo_periodicidad_id" name="nuevo_periodicidad_id">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($periodicidades as $periodicidad)
                                            <option value="{{ $periodicidad->id }}" {{ old('nuevo_periodicidad_id', $mantenimiento->periodicidad_mantenimiento_id) == $periodicidad->id ? 'selected' : '' }}>{{ $periodicidad->nombre }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                                <div class="col-span-12">
                                    <x-base.form-label for="nuevo_descripcion" class="text-xs">Descripción</x-base.form-label>
                                    <x-base.form-textarea class="w-full" id="nuevo_descripcion" name="nuevo_descripcion" rows="2" placeholder="Detalle del nuevo mantenimiento programado...">{{ old('nuevo_descripcion') }}</x-base.form-textarea>
                                </div>
                            </div>
                            <div class="text-xs text-slate-500">
                                <x-base.lucide class="mr-1 inline h-3 w-3" icon="Info" />
                                El nuevo mantenimiento heredará el activo, criterio y criticidad del actual.
                            </div>
                        </div>

                        {{-- Registrar garantía (opcional) --}}
                        <div class="border-t border-slate-200/60 pt-4 dark:border-darkmode-400">
                            <label
                                for="registrar_garantia"
                                class="inline-flex cursor-pointer items-center gap-2 text-sm text-slate-700 dark:text-slate-300"
                            >
                                <input
                                    type="checkbox"
                                    id="registrar_garantia"
                                    name="registrar_garantia"
                                    value="1"
                                    class="form-check-input"
                                    onchange="toggleSeccion('wrapper-garantia', this.checked)"
                                    {{ old('registrar_garantia') ? 'checked' : '' }}
                                />
                                <span class="font-medium">Registrar garantía</span>
                                <span class="ml-1 text-xs text-slate-500">(opcional)</span>
                            </label>
                        </div>

                        {{-- Bloque para registrar la garantía del trabajo realizado --}}
                        <div id="wrapper-garantia" class="space-y-3 rounded-md border border-slate-200/60 p-3 dark:border-darkmode-400" style="display: {{ old('registrar_garantia') ? 'block' : 'none' }};">
                            <div class="grid grid-cols-12 gap-3">
                                <div class="col-span-12 sm:col-span-8">
                                    <x-base.form-label for="garantia_proveedor" class="text-xs">Proveedor</x-base.form-label>
                                    <x-base.form-input class="w-full" id="garantia_proveedor" name="garantia_proveedor" type="text" value="{{ old('garantia_proveedor', $mantenimiento->empresa_contratista) }}" placeholder="Empresa que otorga la garantía" />
                                </div>
                                <div class="col-span-12 sm:col-span-4">
                                    <x-base.form-label for="garantia_estado" class="text-xs">Estado <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-select class="w-full" id="garantia_estado" name="garantia_estado">
                                        <option value="activa" {{ old('garantia_estado', 'activa') === 'activa' ? 'selected' : '' }}>Activa</option>
                                        <option value="en_tramite" {{ old('garantia_estado') === 'en_tramite' ? 'selected' : '' }}>En Trámite</option>
                                    </x-base.form-select>
                                </div>
                                <div class="col-span-12 sm:col-span-4">
                                    <x-base.form-label for="garantia_fecha_inicio" class="text-xs">Fecha Inicio <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-input class="w-full" id="garantia_fecha_inicio" name="garantia_fecha_inicio" type="date" value="{{ old('garantia_fecha_inicio', now()->toDateString()) }}" />
                                </div>
                                <div class="col-span-12 sm:col-span-4">
                                    <x-base.form-label for="garantia_fecha_fin" class="text-xs">Fecha Fin <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-input class="w-full" id="garantia_fecha_fin" name="garantia_fecha_fin" type="date" value="{{ old('garantia_fecha_fin') }}" />
                                </div>
                                <div class="col-span-12 sm:col-span-4">
                                    <x-base.form-label for="garantia_monto" class="text-xs">Monto</x-base.form-label>
                                    <x-base.form-input class="w-full" id="garantia_monto" name="garantia_monto" type="number" step="0.01" min="0" value="{{ old('garantia_monto') }}" placeholder="0.00" />
                                </div>
                                <div class="col-span-12">
                                    <x-base.form-label for="garantia_terminos" class="text-xs">Términos</x-base.form-label>
                                    <x-base.form-textarea class="w-full" id="garantia_terminos" name="garantia_terminos" rows="2" placeholder="Cobertura, condiciones, exclusiones...">{{ old('garantia_terminos') }}</x-base.form-textarea>
                                </div>
                            </div>
                            <div class="text-xs text-slate-500">
                                <x-base.lucide class="mr-1 inline h-3 w-3" icon="Info" />
                                La garantía quedará asociada a este mantenimiento y a su activo ({{ $mantenimiento->nombre_activo }}). Su código se asigna automáticamente.
                            </div>
                        </div>
                    </x-base.dialog.description>

                    <x-base.dialog.footer>
                        <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">
                            Cancelar
                        </x-base.button>
                        <x-base.button class="w-32" type="submit" variant="success">
                            <x-base.lucide class="mr-1 h-4 w-4" icon="CheckCircle" /> Completar
                        </x-base.button>
                    </x-base.dialog.footer>
                </form>
            </x-base.dialog.panel>
        </x-base.dialog>
    @endif

    @push('scripts')
    <script>
        function toggleSeccion(id, mostrar) {
            document.getElementById(id).style.display = mostrar ? 'block' : 'none';
        }
    </script>
    @if ($errors->any())
        {{-- Si la validación falla, reabrir el modal con los datos que el usuario ya había diligenciado --}}
        <script type="module">
            const modal = document.getElementById('completar-mantenimiento-modal');
            if (modal && window.tailwind?.Modal) {
                tailwind.Modal.getOrCreateInstance(modal).show();
            }
        </script>
    @endif
    @endpush
@endsection