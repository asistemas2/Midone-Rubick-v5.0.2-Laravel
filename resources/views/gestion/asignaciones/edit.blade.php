@extends('../layouts/' . $layout)

@section('subhead')
    <title>Reasignar Equipo - Gestión ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Reasignar Equipo: {{ $equipo->codigo }}</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('gestion.asignaciones.index') }}" class="hover:text-primary">Asignación de Equipos</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>Reasignar</span>
    </div>

    @if ($errors->any())
        <div class="intro-y mt-4">
            <div class="rounded-md bg-danger/20 px-5 py-3 text-danger">
                <x-base.lucide class="mr-2 inline h-4 w-4" icon="XCircle" />
                <ul class="mt-1 list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                <form action="{{ route('gestion.asignaciones.update', $equipo) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Info del equipo (solo lectura) --}}
                    <div class="border-b border-slate-200/60 pb-4 mb-4">
                        <h3 class="text-base font-medium">
                            <x-base.lucide class="mr-2 inline h-5 w-5 text-primary" icon="Package" />
                            Equipo
                        </h3>
                    </div>
                    <div class="rounded-md bg-slate-50 p-4 dark:bg-darkmode-400">
                        <div class="grid grid-cols-12 gap-3 text-sm">
                            <div class="col-span-6 sm:col-span-3">
                                <div class="text-xs text-slate-500">Código</div>
                                <div class="mt-1 font-medium">{{ $equipo->codigo }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <div class="text-xs text-slate-500">Nombre</div>
                                <div class="mt-1 font-medium">{{ $equipo->nombre }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <div class="text-xs text-slate-500">Tipo</div>
                                <div class="mt-1 font-medium">{{ $equipo->tipoEquipo?->nombre ?? '—' }}</div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <div class="text-xs text-slate-500">Marca / Modelo</div>
                                <div class="mt-1 font-medium">{{ $equipo->marca?->nombre ?? '—' }} / {{ $equipo->modelo ?? '—' }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Asignación Actual --}}
                    @if($equipo->inmueble)
                    <div class="mt-4 rounded-md border border-warning/30 bg-warning/10 p-4">
                        <div class="mb-2 text-sm font-medium text-warning">
                            <x-base.lucide class="mr-1 inline h-4 w-4" icon="AlertTriangle" /> Asignación Actual
                        </div>
                        <div class="text-sm">
                            <strong>{{ $equipo->inmueble->nombre }}</strong>
                            @if($equipo->inmueble->bloque)
                                — {{ $equipo->inmueble->bloque->nombre }}
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Nuevo Inmueble --}}
                    <div class="border-b border-slate-200/60 pb-4 mb-4 mt-6">
                        <h3 class="text-base font-medium">
                            <x-base.lucide class="mr-2 inline h-5 w-5 text-primary" icon="Building2" />
                            Nuevo Inmueble Destino
                        </h3>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12">
                            <x-base.form-label for="inmueble_id">Inmueble <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select class="w-full @error('inmueble_id') border-danger @enderror" id="inmueble_id" name="inmueble_id">
                                <option value="">Seleccionar inmueble...</option>
                                @foreach($inmuebles as $inm)
                                    <option value="{{ $inm->id }}" {{ old('inmueble_id', $equipo->inmueble_id) == $inm->id ? 'selected' : '' }}>
                                        {{ $inm->nombre }} — {{ $inm->bloque?->nombre ?? 'Sin bloque' }} ({{ $inm->equipos_count }} equipos)
                                    </option>
                                @endforeach
                            </x-base.form-select>
                            @error('inmueble_id') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-5 text-right">
                        <a href="{{ route('gestion.asignaciones.index') }}">
                            <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button>
                        </a>
                        <x-base.button class="w-32" type="submit" variant="primary">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowRightLeft" /> Reasignar
                        </x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
