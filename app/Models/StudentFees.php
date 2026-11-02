<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StudentFees extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'student_fees';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'student_fees_master_id',
        'amount',
        'amount_discount',
        'amount_fine',
        'payment_mode',
        'description',
        'date',
        'received_by',
        'invoice_no',
        'payment_transaction_id',
    ];

    protected $casts = [
        'student_fees_master_id' => 'integer',
        'amount' => 'decimal:2',
        'amount_discount' => 'decimal:2',
        'amount_fine' => 'decimal:2',
        'date' => 'date',
        'received_by' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('student_fees');
    }

    public function master()
    {
        return $this->belongsTo(\App\Models\StudentFeesMaster::class, 'student_fees_master_id');
    }

}
