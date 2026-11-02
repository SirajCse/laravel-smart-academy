<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StudentFeesDeposite extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'student_fees_deposite';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'student_fees_id',
        'amount',
        'payment_mode',
        'date',
    ];

    protected $casts = [
        'student_fees_id' => 'integer',
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('student_fees_deposite');
    }

    public function studentFees()
    {
        return $this->belongsTo(\App\Models\StudentFees::class, 'student_fees_id');
    }

}
