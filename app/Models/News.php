<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    const NUMBER_OF_DAYS_FOR_OLD_NEWS = 7;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'date', 'time', 'author_id', 'content'];

    /**
     * Get the author of the news.
     */
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the author of the news.
     */
    public function newsMarks()
    {
        return $this->hasMany(NewsMark::class);
    }
}
