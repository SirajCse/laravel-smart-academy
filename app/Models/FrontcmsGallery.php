<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FrontcmsGallery extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'frontcms_gallery';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('frontcms_gallery');
    }

    public function media()
    {
        return $this->hasMany(\App\Models\FrontcmsMedia::class, 'gallery_id');
    }

}
