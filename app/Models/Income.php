<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Income extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'income';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'income_head_id',
        'name',
        'invoice_no',
        'date',
        'amount',
        'description',
        'documents',
        'payment_mode',
    ];

    protected $casts = [
        'income_head_id' => 'integer',
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('income');
    }

    public function head()
    {
        return $this->belongsTo(\App\Models\IncomeHead::class, 'income_head_id');
    }

}
