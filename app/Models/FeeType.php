<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FeeType extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'feetype';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'feecategory_id',
        'code',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'feecategory_id' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('feetype');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\FeeCategory::class, 'feecategory_id');
    }

}
