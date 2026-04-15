<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Attendance Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f4f6f9; }
        .card-box {
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }
    </style>
</head>

<body>

<div class="container py-4">

    <h3 class="mb-4">📊 Staff Attendance Dashboard</h3>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Summary -->
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card card-box text-center p-3">
                <h6>Total</h6>
                <h4>{{ $summary['total'] }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-box text-center p-3">
                <h6>Present</h6>
                <h4 class="text-success">{{ $summary['present'] }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-box text-center p-3">
                <h6>Late</h6>
                <h4 class="text-warning">{{ $summary['late'] }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-box text-center p-3">
                <h6>Absent</h6>
                <h4 class="text-danger">{{ $summary['absent'] }}</h4>
            </div>
        </div>

    </div>

    <!-- Actions -->
    <div class="card card-box p-4 mb-4">

        <h5 class="mb-3">Mark Attendance</h5>

        <div class="d-flex gap-3 flex-wrap">

            <form method="POST" action="{{ route('staff.attendance.checkin') }}">
                @csrf
                <input type="hidden" name="latitude" id="lat">
                <input type="hidden" name="longitude" id="lng">

                <button class="btn btn-success">
                    ✅ Check In
                </button>
            </form>

            <form method="POST" action="{{ route('staff.attendance.checkout') }}">
                @csrf
                <button class="btn btn-danger">
                    ⛔ Check Out
                </button>
            </form>

        </div>

    </div>

    <!-- Table -->
    <div class="card card-box p-4">

        <h5 class="mb-3">Today's Attendance</h5>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->staff->name ?? 'N/A' }}</td>
                            <td>{{ $attendance->check_in ?? '-' }}</td>
                            <td>{{ $attendance->check_out ?? '-' }}</td>

                            <td>
                                @if($attendance->status == 'late')
                                    <span class="badge bg-warning text-dark">Late</span>
                                @elseif($attendance->check_in)
                                    <span class="badge bg-success">Present</span>
                                @else
                                    <span class="badge bg-danger">Absent</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No records yet</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        document.getElementById('lat').value = position.coords.latitude;
        document.getElementById('lng').value = position.coords.longitude;
    });
}
</script>

</body>
</html>