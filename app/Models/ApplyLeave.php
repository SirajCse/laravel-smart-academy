<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ApplyLeave extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'apply_leave';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'staff_id',
        'student_session_id',
        'apply_date',
        'leave_from',
        'leave_to',
        'reason',
        'status',
        'approved_by',
        'approved_date',
        'remark',
    ];

    protected $casts = [
        'staff_id' => 'integer',
        'student_session_id' => 'integer',
        'apply_date' => 'date',
        'leave_from' => 'date',
        'leave_to' => 'date',
        'approved_by' => 'integer',
        'approved_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('apply_leave');
    }


}
