<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskActivity extends Model
{
    use HasFactory;

    protected $table = 'tasks_activities';

    protected $fillable = [
        'activity',
        'description',
        'user_id',
        'task_id',
        'origin_id',
        'is_readed'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function activityNotification() : HasMany
    {
        return $this->hasMany(UserNotification::class, 'notification_id');
    }
}
