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
        return Task::where([['project_id', $project_id], ['execution_status_id', 3]])
            ->orderBy('created_at', 'desc')
                ->get();
    }

    public function listById($request)
    {
        return new TaskResource(
            $this->taskRepository->find($request)
        );
    }
    public function listAllBySprintAndProject(int $sprint_id, int $project_id)
    {
        return TaskResource::collection(
            $this->taskRepository->findAllBySprintAndProject($sprint_id, $project_id)
        );
    }

    public function listAllBacklogTaskByProject(int $project_id)
    {
        return TaskResource::collection(
            $this->taskRepository->findAllBacklogTaskByProject($project_id)
        );
    }

    public function listAllByProjectAndStatus(int $project_id, int $status_id)
    {
        return TaskResource::collection(
            $this->taskRepository->findAllByProjectAndStatus($project_id, $status_id)
        );
    }

}
