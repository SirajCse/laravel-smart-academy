<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FrontcmsMedia extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'frontcms_media';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'title',
        'file',
        'file_type',
        'gallery_id',
        'is_active',
    ];

    protected $casts = [
        'gallery_id' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('frontcms_media');
    }


}
