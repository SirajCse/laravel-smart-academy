<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StudentFeesMaster extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'student_fees_master';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'student_session_id',
        'fee_session_group_id',
        'amount',
        'discount_amount',
        'is_system',
    ];

    protected $casts = [
        'student_session_id' => 'integer',
        'fee_session_group_id' => 'integer',
        'amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'is_system' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('student_fees_master');
    }

    public function studentSession()
    {
        return $this->belongsTo(\App\Models\StudentSession::class, 'student_session_id');
    }

    public function feeSessionGroup()
    {
        return $this->belongsTo(\App\Models\FeeSessionGroup::class, 'fee_session_group_id');
    }

}
