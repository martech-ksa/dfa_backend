use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request;

class StaffAttendanceController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $attendances = Attendance::with('staff')
            ->whereDate('date', $today)
            ->get();

        $summary = [
            'total' => $attendances->count(),
            'present' => $attendances->where('check_in', '!=', null)->count(),
            'absent' => $attendances->where('check_in', null)->count(),
        ];

        return view('staff.attendance.dashboard', compact('attendances', 'summary'));
    }

    public function checkIn(Request $request)
    {
        $today = Carbon::today();

        Attendance::updateOrCreate(
            [
                'staff_id' => auth()->id(),
                'date' => $today
            ],
            [
                'check_in' => now()->format('H:i:s'),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]
        );

        return back()->with('success', 'Checked in successfully');
    }

    public function checkOut(Request $request)
    {
        $today = Carbon::today();

        $attendance = Attendance::where('staff_id', auth()->id())
            ->whereDate('date', $today)
            ->first();

        if ($attendance) {
            $attendance->update([
                'check_out' => now()->format('H:i:s')
            ]);
        }

        return back()->with('success', 'Checked out successfully');
    }
}