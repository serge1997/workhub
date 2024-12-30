<?php
namespace App\Core\TaskExecutionStatus;

use App\Http\Resources\TaskExecutionStatusResource;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TaskExecutionStatus;
use Exception;
use Illuminate\Support\Facades\DB;

class TaskExecutionStatusRepository implements TaskExecutionStatusRepositoryInterface
{
    public function create($request)
    {
        throw new Exception("Method not implemented");
    }
    public function listAll()
    {
        return TaskExecutionStatusResource::collection(
            TaskExecutionStatus::query()->get()
        );
    }
    public function find($request)
    {
        throw new Exception("Method not implemented");
    }
    public function update($request)
    {
        throw new Exception("Method not implemented");
    }
    public function delete($request)
    {
        throw new Exception("Method not implemented");
    }

    public function findAllWithTaskCountByProject(int $project_id)
    {
        return TaskExecutionStatus::select(
            DB::raw("IF(COUNT(DISTINCT tasks.id) = 0, '-', COUNT(DISTINCT tasks.id)) as task_count"),
            'task_execution_status.id as id',
            'task_execution_status.name as name_ucfirst',
            'task_execution_status.status'

        )
            ->leftJoin('tasks', function($join) use($project_id) {
                    $join->on('tasks.execution_status_id', '=','task_execution_status.id');
                    $join->on('tasks.project_id', '=', DB::raw("{$project_id}"));
                 })
                ->where('tasks.deleted_at', null)
                    ->groupBy('task_execution_status.id', 'task_execution_status.name', 'task_execution_status.status')
                        ->get();
    }

    public function findAllCountBySprint(int $sprint_id)
    {
        return TaskExecutionStatus::select(
            'task_execution_status.name as name_ucfirst',
            'task_execution_status.status',
            DB::raw("IF(COUNT(DISTINCT tasks.id) = 0, '-', COUNT(DISTINCT tasks.id)) as task_count")
        )
            ->leftJoin('tasks', function($join) use($sprint_id){
                $join->on('tasks.execution_status_id', '=', 'task_execution_status.id');
                $join->on('tasks.sprint_id', '=', DB::raw("{$sprint_id}"));
            })
                ->withoutGlobalScopes()
                    ->groupBy('task_execution_status.name', 'task_execution_status.status')
                        ->orderBy('task_execution_status.id')
                            ->get();
    }

    public function findAllWithTaskCountByTeam(int $team_id)
    {
        $query = TaskExecutionStatus::selectRaw(
            "
                    IF(COUNT(DISTINCT t.id) = 0, '-', COUNT(DISTINCT t.id)) as task_total,
                    task_execution_status.name as name_ucfirst,
                    task_execution_status.status,
                    task_execution_status.id
                "
        )
                ->leftJoin('tasks as t', function($join) use($team_id) {
                    $join->on('task_execution_status.id', '=', 't.execution_status_id');
                    $join->on('t.team_id', '=', DB::raw("{$team_id}"));
                })
                    ->withoutGlobalScopes()
                        ->where([
                            ['t.deleted_at', null]
                        ])
                            ->orderBy('task_execution_status.id')
                                ->groupBy(
                                    'task_execution_status.name', 
                                    'task_execution_status.status', 
                                    'task_execution_status.id', 't.team_id')
                                    ->get();

        $query->each(function($model) use($team_id) {
            $model->name = ucfirst(strtolower($model->name_ucfirst));
            $model->severity = TaskExecutionStatus::setStatusSeverity($model->status);
            $model->tasks = TaskResource::collection(
                Task::where([
                    ['team_id', $team_id],
                    ['execution_status_id', $model->id]
                ])
                    ->get()
            );
        });

        return $query;
    }
}
