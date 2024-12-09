<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubTask extends Model
{
    use HasFactory;

    protected $table = 'subs_tasks';
    protected $fillable = [
        'id',
        'task_id',
        'sub_task_id'
    ];


    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
