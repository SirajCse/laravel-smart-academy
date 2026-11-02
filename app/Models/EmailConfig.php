<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EmailConfig extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'email_config';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'mailer',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'encryption',
        'from_email',
        'from_name',
        'is_active',
    ];

    protected $casts = [
        'smtp_port' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('email_config');
    }


}
