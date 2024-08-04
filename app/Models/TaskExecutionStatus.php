<?php

namespace App\Models;

use App\Enums\TaskExecutionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskExecutionStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'task_execution_status';

    protected $fillable = [
        'name',
        'description'
    ];

    public function task() : HasMany
    {
        return $this->hasMany(Task::class, 'execution_status_id');
    }

    public function fullStatusName() : TaskExecutionStatusEnum
    {
        return match($this->name)
        {
            "BKL" => TaskExecutionStatusEnum::BKL,
            "CON" => TaskExecutionStatusEnum::CON,
            "WAT" => TaskExecutionStatusEnum::WAT,
            "PRO" => TaskExecutionStatusEnum::PRO,
            "CDR" => TaskExecutionStatusEnum::CDR,
            "PRQ" => TaskExecutionStatusEnum::PRQ,
            "TST" => TaskExecutionStatusEnum::TST
        };
    }

    public function executionStatusBg() : string
    {
        return match($this->status){
             "WAT"  => "#7c3aed",
             "PRO" =>  "#0ea5e9",
             "CDR" =>  "#9333ea",
             "CON" =>  "#10b981",
             "TST" =>  "#f59e0b",
             "BKL" =>  "#94a3b8",
             "PRQ" =>  "#e11d48"
        };
    }
}
