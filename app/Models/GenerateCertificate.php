<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class GenerateCertificate extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'generate_certificates';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'certificate_id',
        'student_id',
        'text',
        'file',
        'created_by',
    ];

    protected $casts = [
        'certificate_id' => 'integer',
        'student_id' => 'integer',
        'created_by' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('generate_certificates');
    }

    public function certificate()
    {
        return $this->belongsTo(\App\Models\Certificate::class, 'certificate_id');
    }

    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class, 'student_id');
    }

}
