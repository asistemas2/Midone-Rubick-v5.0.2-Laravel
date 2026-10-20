{{-- Garantías de un activo (inmueble o equipo). Espera: $garantias (colección) --}}
<div class="intro-y box mt-5 p-5">
    <div class="mb-3 flex items-center border-b border-slate-200/60 pb-3 dark:border-darkmode-400">
        <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="ShieldCheck" />
        <span class="text-base font-medium">Garantías ({{ $garantias->count() }})</span>
    </div>
    @if($garantias->count())
        <div class="overflow-x-auto">
            <x-base.table class="border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">CÓDIGO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">PROVEEDOR</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">MANTENIMIENTO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">VIGENCIA</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ESTADO</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach($garantias as $garantia)
                        <x-base.table.tr>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">
                                <a href="{{ route('gestion.garantias.show', $garantia) }}" class="whitespace-nowrap font-medium text-primary">{{ $garantia->codigo }}</a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">{{ $garantia->proveedor ?? '—' }}</x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">
                                @if($garantia->mantenimiento)
                                    <a href="{{ route('gestion.mantenimientos.show', $garantia->mantenimiento) }}" class="text-primary">{{ $garantia->mantenimiento->codigo }}</a>
                                @else
                                    —
                                @endif
                            </x-base.table.td>
                            <x-base.table.td class="whitespace-nowrap border-b-0 bg-white text-center dark:bg-darkmode-600">
                                {{ $garantia->fecha_inicio?->format('d/m/Y') ?? '—' }} - {{ $garantia->fecha_fin?->format('d/m/Y') ?? '—' }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center dark:bg-darkmode-600">{!! $garantia->estado_badge !!}</x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                </x-base.table.tbody>
            </x-base.table>
        </div>
    @else
        <div class="py-4 text-center text-sm text-slate-500">Sin garantías registradas.</div>
    @endif
</div>
