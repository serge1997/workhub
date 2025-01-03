<?php
namespace App\Core\Task\Actions;

use App\Core\TaskActivity\TaskActivityRepositoryInterface;
use App\Models\Task;
use App\Models\TaskExecutionStatus;

final class ExecutionStatusUpdateAction
{
    public function __construct(
        private Task $task,
        private readonly mixed $request,
        private TaskActivityRepositoryInterface $taskActivityRepositoryInterface
    )
    {

    }

    public function handle()
    {
       if($this->task->hasSubTaskNotConcluded() && $this->request->execution_status_id == TaskExecutionStatus::CONCLUDED){
            throw new \Exception("Essa tarefa tem sub tarefa(s) nã conluida(s) Nécessario concluir as sub tarefas antes da tarefa pai");
       }
       $this->task->update([
        'execution_status_id' => $this->request->execution_status_id,
       ]);
       $this->taskActivityRepositoryInterface->create(
            $this->request->user()->id,
            $this->task->id,
            "Atualizou a tarefa para " . $this->task->executionStatus->name,
            "Task",
            $this->task->id
       );
    }

    private function progress()
    {
        $this->task->update([
            'execution_status' => Task::IN_PROGRESS
        ]);
    }

    private function concluded()
    {
        $this->task->update([
            'execution_status' => Task::CONCLUDED
        ]);
    }
}
