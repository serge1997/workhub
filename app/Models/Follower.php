<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follower extends Model
{
    use HasFactory;

    protected $table = 'followers';

    protected $fillable = [
        'task_id',
        'follower_id',
        'deleted_at',
        'deleted_reason'
    ];

    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function isDeleted() : bool
    {
        return $this->deleted_at !== null;
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
