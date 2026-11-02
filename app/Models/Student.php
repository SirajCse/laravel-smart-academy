<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Student extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'students';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'admission_no',
        'roll_no',
        'admission_date',
        'firstname',
        'middlename',
        'lastname',
        'image',
        'mobileno',
        'email',
        'state',
        'city',
        'pincode',
        'current_address',
        'permanent_address',
        'guardian_is',
        'guardian_name',
        'guardian_relation',
        'guardian_phone',
        'guardian_email',
        'guardian_occupation',
        'guardian_address',
        'guardian_image',
        'father_name',
        'father_phone',
        'father_occupation',
        'father_image',
        'mother_name',
        'mother_phone',
        'mother_occupation',
        'mother_image',
        'gender',
        'dob',
        'category_id',
        'religion',
        'cast',
        'blood_group',
        'height',
        'weight',
        'measurement_date',
        'previous_school',
        'previous_school_details',
        'admission_reason',
        'note',
        'is_active',
        'disable_reason_id',
        'disable_date',
        'disable_note',
        'rte',
        'adhar_no',
        'samagra_id',
        'bank_account_no',
        'bank_name',
        'ifsc_code',
        'national_identification_no',
        'local_identification_no',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'dob' => 'date',
        'category_id' => 'integer',
        'measurement_date' => 'date',
        'is_active' => 'boolean',
        'disable_reason_id' => 'integer',
        'disable_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('students');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function disableReason()
    {
        return $this->belongsTo(\App\Models\DisableReason::class, 'disable_reason_id');
    }

    public function sessions()
    {
        return $this->hasMany(\App\Models\StudentSession::class, 'student_id');
    }

    public function attendances()
    {
        return $this->hasMany(\App\Models\StudentAttendence::class, 'student_id');
    }

    public function fees()
    {
        return $this->hasMany(\App\Models\StudentFeesMaster::class, 'student_id');
    }

    public function homeworks()
    {
        return $this->hasMany(\App\Models\Homework::class, 'student_id');
    }

}
