<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BookIssue extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'book_issues';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'book_id',
        'member_id',
        'member_type',
        'issue_date',
        'return_date',
        'actual_return_date',
        'is_returned',
        'fine_amount',
        'remark',
    ];

    protected $casts = [
        'book_id' => 'integer',
        'member_id' => 'integer',
        'issue_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',
        'is_returned' => 'boolean',
        'fine_amount' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('book_issues');
    }

    public function book()
    {
        return $this->belongsTo(\App\Models\Book::class, 'book_id');
    }

}
