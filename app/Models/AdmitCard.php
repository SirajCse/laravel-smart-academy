<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AdmitCard extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'admitcard';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'title',
        'exam_group_id',
        'template',
        'background',
        'logo',
        'left_logo',
        'right_logo',
        'is_active',
    ];

    protected $casts = [
        'exam_group_id' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('admitcard');
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\ExamGroup::class, 'exam_group_id');
    }

}
