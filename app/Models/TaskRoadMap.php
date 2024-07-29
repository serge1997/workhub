<?php

namespace App\Models;

use App\Observers\TaskRoadMapObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(TaskRoadMapObserver::class)]
class TaskRoadMap extends Model
{
    use HasFactory;

    protected $table = 'tasks_roadmap';

    protected $fillable = [
        'title',
        'description',
        'task_id',
        'user_id',
        'deleted_at',
        'deleted_reason'
    ];

    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
