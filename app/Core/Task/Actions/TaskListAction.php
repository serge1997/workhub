<?php
namespace App\Core\Task\Actions;

use App\Models\Task;

final class TaskListAction
{

    public function listByProject(int $project_id)
    {
        return Task::where([['project_id', $project_id], ['execution_status_id', 3]])->get();
    }
}
