@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Hero -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-2xl shadow-lg mb-6">
        <h2 class="text-xl font-semibold">Welcome back 👋</h2>
        <p class="text-sm text-blue-100">Here’s your system overview today</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

        @foreach([
            ['Students',$students ?? 0,'🎓','text-blue-500'],
            ['Programs',$programs ?? 0,'📚','text-green-500'],
            ['Levels',$levels ?? 0,'🏫','text-purple-500'],
            ['Classes',$classes ?? 0,'🧑‍🏫','text-orange-500']
        ] as $item)

        <div class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">{{ $item[0] }}</p>
                    <h2 class="text-3xl font-bold text-gray-900">{{ $item[1] }}</h2>
                </div>
                <div class="{{ $item[3] }} text-3xl">{{ $item[2] }}</div>
            </div>
        </div>

        @endforeach

    </div>

    <!-- Attendance -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

        <div class="bg-white p-4 rounded-2xl shadow-sm border text-center">
            <p class="text-gray-500 text-sm">Present</p>
            <h3 class="text-2xl font-bold text-green-500">{{ $attendance['present'] ?? 0 }}</h3>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border text-center">
            <p class="text-gray-500 text-sm">Late</p>
            <h3 class="text-2xl font-bold text-amber-500">{{ $attendance['late'] ?? 0 }}</h3>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border text-center">
            <p class="text-gray-500 text-sm">Absent</p>
            <h3 class="text-2xl font-bold text-red-500">{{ $attendance['absent'] ?? 0 }}</h3>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border text-center">
            <p class="text-gray-500 text-sm">Total</p>
            <h3 class="text-2xl font-bold text-blue-500">{{ $attendance['total'] ?? 0 }}</h3>
        </div>

    </div>

    <!-- Chart -->
    <div class="bg-white shadow-sm rounded-2xl p-6 border">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">
            📊 Attendance Trend (Last 7 Days)
        </h2>

        <canvas id="attendanceChart"></canvas>
    </div>

</div>

<!-- Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('attendanceChart'), {
    type: 'bar',
    data: {
        labels: @json($chartLabels ?? []),
        datasets: [
            {
                label: 'Present',
                data: @json($presentData ?? []),
                backgroundColor: '#22c55e',
                borderRadius: 6
            },
            {
                label: 'Late',
                data: @json($lateData ?? []),
                backgroundColor: '#f59e0b',
                borderRadius: 6
            },
            {
                label: 'Absent',
                data: @json($absentData ?? []),
                backgroundColor: '#ef4444',
                borderRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>

@endsection