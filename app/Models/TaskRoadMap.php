<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskRoadMap extends Model
{
    use HasFactory;

    protected $table = 'tasks_roadmap';

    protected $fillable = [
        'title',
        'description',
        'task_id',
        'deleted_at',
        'deleted_reason'
    ];

    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
