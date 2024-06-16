<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $table = "tasks";
    protected $fillable = [
        'title',
        'priority',
        'description',
        'manager_id',
        'user_id',
        'execution_delay',
        'deleted_at',
        'delay_used'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function manager() : BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function annex() : HasMany
    {
        return $this->hasMany(Annex::class, 'task_id');
    }

    public function followers() : HasMany
    {
        return $this->hasMany(Follower::class, 'task_id');
    }

    public function roadMap() : HasMany
    {
        return $this->hasMany(TaskRoadMap::class, 'task_id');
    }
}
