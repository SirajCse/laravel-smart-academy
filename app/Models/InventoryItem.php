<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InventoryItem extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'item';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'item_category_id',
        'name',
        'item_code',
        'description',
        'unit',
        'purchase_price',
        'sale_price',
        'opening_quantity',
        'current_quantity',
        'reorder_level',
        'image',
        'is_active',
    ];

    protected $casts = [
        'item_category_id' => 'integer',
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'opening_quantity' => 'integer',
        'current_quantity' => 'integer',
        'reorder_level' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('item');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\ItemCategory::class, 'item_category_id');
    }

}
