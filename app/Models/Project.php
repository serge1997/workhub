<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $table = "projects";
    protected $fillable = [
        'id',
        'name',
        'descricao',
        'severity',
        'start_at',
        'end_at'
    ];

    public function tasks() : HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function tasks_in_progress()
    {
        return $this->tasks()->where('execution_status_id', 3);
    }
    public function tasks_concluded()
    {
        return $this->tasks()->where('execution_status_id', 8);
    }

    public function members_count()
    {
        return $this->tasks()
            ->selectRaw('COUNT(DISTINCT(user_id)) as user_id');

    }
}
