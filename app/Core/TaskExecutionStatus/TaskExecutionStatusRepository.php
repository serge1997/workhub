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
            DB::raw("COUNT(DISTINCT tasks.id) as task_count"),
            'task_execution_status.id as id',
            'task_execution_status.name as name_ucfirst',
            'task_execution_status.status as severity'

        )
            ->join('tasks', 'tasks.execution_status_id', '=','task_execution_status.id')
                ->where([
                    ['tasks.deleted_at', null],
                    ['tasks.project_id', $project_id]
                ])
                    ->groupBy('task_execution_status.id', 'task_execution_status.name', 'task_execution_status.status')
                        ->get();
    }
}
