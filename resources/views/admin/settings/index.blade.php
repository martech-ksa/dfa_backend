@extends('layouts.app')

@section('content')

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<div class="max-w-6xl mx-auto">

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-2xl shadow-lg mb-6">
        <h2 class="text-xl font-semibold">⚙️ System Settings</h2>
        <p class="text-sm text-blue-100">Configure geofencing & attendance rules</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow p-6">

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <!-- MAP SECTION -->
            <div class="mb-6">
                <label class="text-sm text-gray-600">Select Office Location (Map)</label>
                <div id="map" class="mt-2" style="height: 400px; border-radius: 12px;"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Latitude -->
                <div>
                    <label class="text-sm text-gray-600">Office Latitude</label>
                    <input type="text" id="latitude" name="office_lat"
                           value="{{ $setting->office_lat ?? '' }}"
                           class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Longitude -->
                <div>
                    <label class="text-sm text-gray-600">Office Longitude</label>
                    <input type="text" id="longitude" name="office_lng"
                           value="{{ $setting->office_lng ?? '' }}"
                           class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Radius -->
                <div>
                    <label class="text-sm text-gray-600">Allowed Radius (meters)</label>
                    <input type="number" id="radius" name="radius"
                           value="{{ $setting->radius ?? 100 }}"
                           class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Resumption Time -->
                <div>
                    <label class="text-sm text-gray-600">Resumption Time</label>
                    <input type="time" name="resumption_time"
                           value="{{ $setting->resumption_time ?? '' }}"
                           class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

            </div>

            <!-- Button -->
            <div class="mt-6 flex justify-end">
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Save Settings
                </button>
            </div>

        </form>

    </div>

    <!-- Info -->
    <div class="mt-6 bg-yellow-50 border border-yellow-200 p-4 rounded-xl">
        <p class="text-sm text-yellow-700">
            📍 Staff must be within the defined radius to check in.<br>
            ⏰ Late status is determined based on resumption time.
        </p>
    </div>

</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    let latInput = document.getElementById('latitude');
    let lngInput = document.getElementById('longitude');
    let radiusInput = document.getElementById('radius');

    // Default (fallback to Makkah region since you're in KSA)
    let defaultLat = 21.3891;
    let defaultLng = 39.8579;

    let lat = latInput.value || defaultLat;
    let lng = lngInput.value || defaultLng;

    // Initialize map
    let map = L.map('map').setView([lat, lng], 13);

    // Tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Marker
    let marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    // Circle (Geofence)
    let circle = L.circle([lat, lng], {
        radius: radiusInput.value || 100,
        color: 'blue',
        fillOpacity: 0.2
    }).addTo(map);

    // Update inputs when marker dragged
    marker.on('drag', function () {
        let pos = marker.getLatLng();
        latInput.value = pos.lat.toFixed(6);
        lngInput.value = pos.lng.toFixed(6);
        circle.setLatLng(pos);
    });

    // Click map to move marker
    map.on('click', function (e) {
        let { lat, lng } = e.latlng;
        marker.setLatLng([lat, lng]);

        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);

        circle.setLatLng([lat, lng]);
    });

    // Update radius live
    radiusInput.addEventListener('input', function () {
        circle.setRadius(this.value);
    });

    // 🔥 FIX: Sidebar / hidden container issue
    setTimeout(() => {
        map.invalidateSize();
    }, 300);

});
</script>

@endsection