<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SendNotification extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'send_notification';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'title',
        'message',
        'notification_type',
        'sent_to',
        'role_id',
        'class_id',
        'section_id',
        'send_by',
        'send_date',
        'is_active',
    ];

    protected $casts = [
        'role_id' => 'integer',
        'class_id' => 'integer',
        'section_id' => 'integer',
        'send_by' => 'integer',
        'send_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('send_notification');
    }


}
