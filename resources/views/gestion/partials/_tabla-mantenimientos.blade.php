{{-- Mantenimientos de un activo (inmueble o equipo). Espera: $mantenimientos (colección, ordenada) --}}
<div class="intro-y box mt-5 p-5">
    <div class="mb-3 flex items-center border-b border-slate-200/60 pb-3 dark:border-darkmode-400">
        <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="Wrench" />
        <span class="text-base font-medium">Mantenimientos ({{ $mantenimientos->count() }})</span>
    </div>
    @if($mantenimientos->count())
        <div class="overflow-x-auto">
            <x-base.table class="border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">CÓDIGO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">DESCRIPCIÓN</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">TIPO</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">FECHA PROG.</x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">ESTADO</x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach($mantenimientos as $mant)
                        <x-base.table.tr>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">
                                <a href="{{ route('gestion.mantenimientos.show', $mant) }}" class="whitespace-nowrap font-medium text-primary">{{ $mant->codigo }}</a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white dark:bg-darkmode-600">{{ Str::limit($mant->descripcion, 60) }}</x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center dark:bg-darkmode-600">{!! $mant->tipo_mantenimiento_badge !!}</x-base.table.td>
                            <x-base.table.td class="whitespace-nowrap border-b-0 bg-white text-center dark:bg-darkmode-600">{{ $mant->fecha_programada?->format('d/m/Y') ?? '—' }}</x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center dark:bg-darkmode-600">{!! $mant->estado_badge !!}</x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                </x-base.table.tbody>
            </x-base.table>
        </div>
    @else
        <div class="py-4 text-center text-sm text-slate-500">Sin mantenimientos registrados.</div>
    @endif
</div>
