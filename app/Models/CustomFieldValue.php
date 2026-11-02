<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CustomFieldValue extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'custom_field_values';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'custom_field_id',
        'belong_id',
        'value',
    ];

    protected $casts = [
        'custom_field_id' => 'integer',
        'belong_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('custom_field_values');
    }

    public function field()
    {
        return $this->belongsTo(\App\Models\CustomField::class, 'custom_field_id');
    }

}
