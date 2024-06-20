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

    public function handle($request)
    {
        return match($this->task->execution_status)
        {
            Task::WAITING => $this->progress($request),
            Task::IN_PROGRESS => $this->concluded($request),
            Task::CONCLUDED => null
        };
    }

    public function progress()
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
