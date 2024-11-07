<?php
namespace App\Core\Task\Actions;

use App\Core\Task\TaskRepositoryInterface;
use App\Http\Resources\TaskResource;
use App\Models\Task;

final class TaskListAction
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    )
    {

    }

    public function listByProject(int $project_id)
    {
        return Task::where([['project_id', $project_id], ['execution_status_id', 3]])->get();
    }

    public function listById($request)
    {
        return new TaskResource(
            $this->taskRepository->find($request)
        );
    }
}
