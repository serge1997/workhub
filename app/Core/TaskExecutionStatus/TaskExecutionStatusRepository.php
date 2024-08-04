<?php
namespace App\Core\TaskExecutionStatus;

use App\Http\Resources\TaskExecutionStatusResource;
use App\Models\TaskExecutionStatus;
use Exception;

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
}
