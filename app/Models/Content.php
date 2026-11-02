<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Content extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'content';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content_type_id',
        'page_type',
        'is_menu',
        'is_active',
        'publish_date',
        'image',
        'gallery_id',
    ];

    protected $casts = [
        'content_type_id' => 'integer',
        'is_menu' => 'boolean',
        'is_active' => 'boolean',
        'publish_date' => 'date',
        'gallery_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('content');
    }

    public function type()
    {
        return $this->belongsTo(\App\Models\Contenttype::class, 'content_type_id');
    }

}
