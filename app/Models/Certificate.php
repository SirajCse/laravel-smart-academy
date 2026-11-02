<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Certificate extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'certificates';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'certificate_name',
        'certificate_text',
        'template',
        'background',
        'logo',
        'left_logo',
        'right_logo',
        'is_active',
        'enable_user_image',
        'enable_student_name',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'enable_user_image' => 'boolean',
        'enable_student_name' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('certificates');
    }


}
