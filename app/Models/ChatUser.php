<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ChatUser extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'chat_users';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'staff_id',
        'student_id',
        'parent_id',
        'is_active',
        'last_seen',
    ];

    protected $casts = [
        'staff_id' => 'integer',
        'student_id' => 'integer',
        'parent_id' => 'integer',
        'is_active' => 'boolean',
        'last_seen' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('chat_users');
    }


}
