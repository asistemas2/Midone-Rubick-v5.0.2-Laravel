{{-- Componente de Selección de Ubicación con Leaflet.js --}}
{{-- Uso: @include('components.map-selector', ['latitud' => old('latitud', 3.55846), 'longitud' => old('longitud', -76.38627)]) --}}

@php
    $mapId = 'map-selector-' . uniqid();
    $lat = $latitud ?? 3.55846;
    $lng = $longitud ?? -76.38627;
@endphp

<div class="rounded-md border border-slate-200 dark:border-darkmode-400">
    <div id="{{ $mapId }}" style="height: 350px; border-radius: 6px;"></div>
    <div class="flex items-center gap-4 p-3 bg-slate-50 dark:bg-darkmode-400 rounded-b-md">
        <div class="flex items-center gap-2">
            <x-base.lucide class="h-4 w-4 text-slate-500" icon="MapPin" />
            <label class="text-xs text-slate-500">Latitud:</label>
            <x-base.form-input
                class="!box w-40 text-xs"
                id="{{ $mapId }}-lat"
                name="latitud"
                type="number"
                step="0.00000001"
                value="{{ $lat }}"
                placeholder="Latitud"
            />
        </div>
        <div class="flex items-center gap-2">
            <label class="text-xs text-slate-500">Longitud:</label>
            <x-base.form-input
                class="!box w-40 text-xs"
                id="{{ $mapId }}-lng"
                name="longitud"
                type="number"
                step="0.00000001"
                value="{{ $lng }}"
                placeholder="Longitud"
            />
        </div>
        <div class="ml-auto">
            <x-base.button type="button" variant="outline-secondary" class="text-xs" onclick="resetMap_{{ str_replace('-', '_', $mapId) }}()">
                <x-base.lucide class="mr-1 h-3 w-3" icon="RotateCcw" /> Centrar
            </x-base.button>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function() {
    var mapId = '{{ $mapId }}';
    var latInput = document.getElementById(mapId + '-lat');
    var lngInput = document.getElementById(mapId + '-lng');
    var initialLat = parseFloat(latInput.value) || {{ $lat }};
    var initialLng = parseFloat(lngInput.value) || {{ $lng }};

    var map = L.map(mapId).setView([initialLat, initialLng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    var marker = L.marker([initialLat, initialLng], {
        draggable: true
    }).addTo(map);

    marker.bindPopup('<strong>Ubicación del Inmueble</strong><br>Arrástrelo para ajustar').openPopup();

    marker.on('dragend', function(e) {
        var pos = marker.getLatLng();
        latInput.value = pos.lat.toFixed(8);
        lngInput.value = pos.lng.toFixed(8);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        latInput.value = e.latlng.lat.toFixed(8);
        lngInput.value = e.latlng.lng.toFixed(8);
    });

    latInput.addEventListener('change', function() {
        var lat = parseFloat(this.value);
        var lng = parseFloat(lngInput.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng]);
        }
    });

    lngInput.addEventListener('change', function() {
        var lat = parseFloat(latInput.value);
        var lng = parseFloat(this.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng]);
        }
    });

    window['resetMap_{{ str_replace("-", "_", $mapId) }}'] = function() {
        var defaultLat = {{ $lat }};
        var defaultLng = {{ $lng }};
        marker.setLatLng([defaultLat, defaultLng]);
        map.setView([defaultLat, defaultLng], 16);
        latInput.value = defaultLat.toFixed(8);
        lngInput.value = defaultLng.toFixed(8);
    };
})();
</script>
@endpush