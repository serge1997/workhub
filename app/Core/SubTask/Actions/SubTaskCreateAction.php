<?php
namespace App\Core\SubTask\Actions;

use App\Core\SubTask\Exception\SubTaskException;
use App\Core\SubTask\Repository\SubTaskRepositoryInterface;
use App\Core\Task\TaskRepositoryInterface;
use App\Http\Resources\SubTaskResource;
use Illuminate\Foundation\Http\FormRequest;
class SubTaskCreateAction
{
    public function __construct(
        private SubTaskRepositoryInterface $subTaskRepository,
        private TaskRepositoryInterface $taskRepository
    ){}

    public function run(FormRequest $request)
    {
        $parentTask = $this->taskRepository->find($request->task_id);
        if (!$parentTask){
            throw new SubTaskException("Tarefa pai não encontrada");
        }
        $subTask = $this->taskRepository->create($request);

        return new SubTaskResource(
            $this->subTaskRepository->create($parentTask, $subTask)
        );

    }
}