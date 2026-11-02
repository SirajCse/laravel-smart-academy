<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ChatMessage extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'chat_messages';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'chat_user_id',
        'message',
        'file',
        'sender_id',
        'sender_type',
        'is_read',
        'created_at',
    ];

    protected $casts = [
        'chat_user_id' => 'integer',
        'sender_id' => 'integer',
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('chat_messages');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\ChatUser::class, 'chat_user_id');
    }

}
