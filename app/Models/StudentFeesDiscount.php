<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StudentFeesDiscount extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'student_fees_discounts';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'student_fees_master_id',
        'fees_discount_id',
        'amount',
        'status',
        'description',
    ];

    protected $casts = [
        'student_fees_master_id' => 'integer',
        'fees_discount_id' => 'integer',
        'amount' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('student_fees_discounts');
    }

    public function master()
    {
        return $this->belongsTo(\App\Models\StudentFeesMaster::class, 'student_fees_master_id');
    }

    public function discount()
    {
        return $this->belongsTo(\App\Models\FeesDiscount::class, 'fees_discount_id');
    }

}
