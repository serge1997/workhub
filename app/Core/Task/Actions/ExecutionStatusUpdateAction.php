<?php
namespace App\Core\Task\Actions;

use App\Models\Task;

final class ExecutionStatusUpdateAction
{
    public function __construct(
        private Task $task
    )
    {

    }

    public function handle()
    {
        return match($this->task->execution_status)
        {
            Task::WAITING => $this->progress(),
            Task::IN_PROGRESS => $this->concluded(),
            Task::CONCLUDED => null
        };
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
