<?php
namespace App\Core\Task\Actions;

use App\Core\Task\TaskRepositoryInterface;
use App\Core\TaskActivity\TaskActivityRepositoryInterface;
use App\Models\Task;
use App\Services\Base\BaseAction;

final class TaskUpdateAction extends BaseAction
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private TaskActivityRepositoryInterface $taskActivityRepository
    ){}

    public function priority(Task $task, $request)
    {
        if ($task->priority != $request->priority){

            $task->update([
                'priority' => $request->priority
            ]);

            $this->taskActivityRepository->create(
                $request->user()->id,
                $task->id,
                'atualizou a prioridade para ' . $task->prioriryFullDescription($task->priority),
                'update'
            );
        }
        return $task;
    }

    public function updateUserId(Task $task, $request)
    {
        if ($task->user_id != $request->user_id){

            $task->update([
                'user_id' => $request->user_id
            ]);
            $this->logActivity(
                $request->user()->id,
                $task->id,
                'mudou o responsavel para ' . $task->user->name,
                'update'
            );
        }
        return $task;
    }
}
