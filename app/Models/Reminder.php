<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    const STATUS_ON_HOLD = 'on_hold';
    const STATUS_COMPLETED = 'completed';

    const STATUSES = [
        self::STATUS_ON_HOLD,
        self::STATUS_COMPLETED

    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'date', 'time', 'author_id', 'content', 'status'];

    /**
     * Get the author of the reminder.
     */
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
