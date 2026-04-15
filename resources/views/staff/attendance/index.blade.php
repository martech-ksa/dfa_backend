@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md text-center">

        {{-- Title --}}
        <h2 class="text-2xl font-bold mb-2">Staff Attendance</h2>
        <p class="text-gray-500 mb-6">Mark your attendance using GPS</p>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error --}}
        <div id="errorBox" class="hidden bg-red-100 text-red-700 p-3 rounded mb-4"></div>

        {{-- Status --}}
        <div id="statusBox" class="mb-4 text-sm text-gray-600">
            Click button to get location...
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('staff.attendance.mark') }}" id="attendanceForm">
            @csrf

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <button type="button"
                    onclick="handleAttendance()"
                    id="attendanceBtn"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">

                📍 Check In / Check Out

            </button>
        </form>

        {{-- Info --}}
        <div class="mt-6 text-xs text-gray-400">
            Location must be within school premises
        </div>

    </div>

</div>


<script>

function handleAttendance() {

    const btn = document.getElementById('attendanceBtn');
    const status = document.getElementById('statusBox');
    const errorBox = document.getElementById('errorBox');

    errorBox.classList.add('hidden');

    if (!navigator.geolocation) {
        errorBox.innerText = "Geolocation is not supported on this device.";
        errorBox.classList.remove('hidden');
        return;
    }

    btn.innerText = "Getting location...";
    btn.disabled = true;

    navigator.geolocation.getCurrentPosition(
        function(position) {

            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            status.innerHTML = `
                <strong>Location captured</strong><br>
                Lat: ${lat.toFixed(5)} | Lng: ${lng.toFixed(5)}
            `;

            // Submit form
            document.getElementById('attendanceForm').submit();
        },
        function(error) {

            btn.disabled = false;
            btn.innerText = "📍 Check In / Check Out";

            let message = "Unable to get location.";

            if (error.code === 1) message = "Permission denied. Please allow location.";
            if (error.code === 2) message = "Location unavailable.";
            if (error.code === 3) message = "Location timeout.";

            errorBox.innerText = message;
            errorBox.classList.remove('hidden');
        },
        {
            enableHighAccuracy: true,
            timeout: 10000
        }
    );
}

</script>

@endsection