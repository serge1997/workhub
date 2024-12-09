<?php
namespace App\Core\SubTask\Repository;

use App\Models\Task;

class SubTaskRepository implements SubTaskRepositoryInterface
{

    public function create(Task $parentTask,Task $subTask)
    {
        return $parentTask->subTasks()->create([
            'sub_task_id' => $subTask->id
        ]);
    }
}
