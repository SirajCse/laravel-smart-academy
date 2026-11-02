<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class GenerateIdCard extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'generate_idcard';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'idcard_template_id',
        'student_id',
        'file',
        'created_by',
    ];

    protected $casts = [
        'idcard_template_id' => 'integer',
        'student_id' => 'integer',
        'created_by' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('generate_idcard');
    }


}
