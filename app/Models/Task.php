<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\UserTypeEnum;
use App\Models\Scopes\NotDeletScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ScopedBy(NotDeletScope::class)]
class Task extends Model
{
    use HasFactory;

    const IN_PROGRESS = 'PRO';
    const WAITING = 'WAT';
    const CONCLUDED = 'CON';

    const URG = "URG";
    const ALT = 'ALT';
    const MED = 'MED';
    const LOW = 'BAX';

    protected $table = "tasks";
    protected $fillable = [
        'title',
        'priority',
        'description',
        'manager_id',
        'user_id',
        'execution_delay',
        'deleted_at',
        'delay_used',
        'execution_status',
        'execution_status_id',
        'sprint_id',
        'project_id',
        'team_id'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function manager() : BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function annexes() : HasMany
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

   public function comment() : HasMany
   {
        return $this->hasMany(Comment::class, 'task_id');
   }

   public function customColumnValue() : HasMany
   {
        return $this->hasMany(CustomColumnsValue::class, 'task_id');
   }

   public function fullExecutionLabel() : string
   {
        return match($this->execution_status)
        {
            "WAT" => "Pendente",
            "PRO" => "Progress",
            "CON" => "Concuido"
        };
   }

    public function isAdminAndTaskOwner(int $auth_id) : bool
    {
        return $this->manager->user_type === UserTypeEnum::ADMIN->value
            && $this->manager_id === $auth_id;
    }

    public function taskActivity() : HasMany
    {
        return $this->hasMany(TaskActivity::class, 'task_id');
    }

    public function executionStatus() : BelongsTo
    {
        return $this->belongsTo(TaskExecutionStatus::class, 'execution_status_id');
    }

    public function sprint() : BelongsTo
    {
        return $this->belongsTo(Sprint::class, 'sprint_id');
    }

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    public function prioriryFullDescription(?string $priority) : ?string
    {
        return match($priority)
        {
            Task::URG => "Urgente",
            Task::ALT => "Alta",
            Task::MED => "Media",
            Task::LOW => "Baixa",
            default => null
        };
    }

    public function subTasks() : HasMany
    {
        return $this->hasMany(SubTask::class, 'task_id');
    }

    public function isSubTask() : bool
    {
        return SubTask::where('sub_task_id', $this->id)->exists();
    }

    public function hasSubTask() : bool
    {
        return SubTask::where('task_id', $this->id)->exists();
    }
   public function isConcluded()
   {
        return $this->execution_status_id === TaskExecutionStatus::CONCLUDED;
   }

   public function isNotConcluded()
   {
        return $this->execution_status_id !== TaskExecutionStatus::CONCLUDED;
   }

   public function parent(): HasOne
   {
        return $this->hasOne(SubTask::class, 'sub_task_id', 'id');
   }

   public function hasSubTaskNotConcluded()
   {
        return SubTask::whereIn('sub_task_id', function($query){
            $query->select('id')
                ->from('tasks')
                    ->where('execution_status_id','<>',TaskExecutionStatus::CONCLUDED);
        })->where('task_id', $this->id)
            ->exists();
    }
}
