<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ItemIssue extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'item_issue';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'item_id',
        'member_id',
        'member_type',
        'issue_date',
        'return_date',
        'actual_return_date',
        'quantity',
        'is_returned',
        'remark',
    ];

    protected $casts = [
        'item_id' => 'integer',
        'member_id' => 'integer',
        'issue_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',
        'quantity' => 'integer',
        'is_returned' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('item_issue');
    }

    public function item()
    {
        return $this->belongsTo(\App\Models\InventoryItem::class, 'item_id');
    }

}
