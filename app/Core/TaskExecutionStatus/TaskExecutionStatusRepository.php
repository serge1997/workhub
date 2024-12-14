<?php
namespace App\Core\TaskExecutionStatus;

use App\Http\Resources\TaskExecutionStatusResource;
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
}
