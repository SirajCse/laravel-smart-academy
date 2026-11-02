<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Expense extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'expense';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'expense_head_id',
        'name',
        'invoice_no',
        'date',
        'amount',
        'description',
        'documents',
        'payment_mode',
    ];

    protected $casts = [
        'expense_head_id' => 'integer',
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('expense');
    }

    public function head()
    {
        return $this->belongsTo(\App\Models\ExpenseHead::class, 'expense_head_id');
    }

}
