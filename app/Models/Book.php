<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Book extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'books';

    protected $primaryKey = 'id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'book_title',
        'book_no',
        'isbn_no',
        'subject_id',
        'rack_no',
        'publish_year',
        'publisher',
        'author',
        'qty',
        'perunitcost',
        'postdate',
        'description',
        'cover_image',
        'is_active',
    ];

    protected $casts = [
        'subject_id' => 'integer',
        'qty' => 'integer',
        'perunitcost' => 'decimal:2',
        'postdate' => 'date',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id'])
            ->logOnlyDirty()
            ->useLogName('books');
    }

    public function issues()
    {
        return $this->hasMany(\App\Models\BookIssue::class, 'book_id');
    }

}
