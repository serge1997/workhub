<?php
namespace App\Core\SubTask\Actions;

use App\Core\SubTask\Repository\SubTaskRepositoryInterface;
use App\Core\Task\TaskRepositoryInterface;
use App\Http\Resources\TaskResource;

class SubTaskListAction
{

    public function __construct(
        private SubTaskRepositoryInterface $subTaskRepository,
        private TaskRepositoryInterface $taskRepository
    ){}

    public function listAllByParent($request)
    {
        $task = $this->taskRepository->find($request);
        return TaskResource::collection(
            $this->subTaskRepository->findAllByParentTask($task)
        );
    }
}
