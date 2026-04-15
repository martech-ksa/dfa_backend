class StaffAttendance extends Model
{
    protected $fillable = [
        'staff_id',
        'date',
        'check_in',
        'check_out',
        'latitude',
        'longitude',
        'is_within_geofence'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}