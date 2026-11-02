<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FrontcmsMenu extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'frontcms_menu';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'title',
        'slug',
        'url',
        'parent_id',
        'page_id',
        'order',
        'is_active',
        'open_in_new_tab',
    ];

    protected $casts = [
        'parent_id' => 'integer',
        'page_id' => 'integer',
        'order' => 'integer',
        'is_active' => 'boolean',
        'open_in_new_tab' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('frontcms_menu');
    }


}
