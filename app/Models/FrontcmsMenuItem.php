<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FrontcmsMenuItem extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'frontcms_menuitems';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'menu_id',
        'item_type',
        'item_id',
        'order',
    ];

    protected $casts = [
        'menu_id' => 'integer',
        'item_id' => 'integer',
        'order' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('frontcms_menuitems');
    }


}
