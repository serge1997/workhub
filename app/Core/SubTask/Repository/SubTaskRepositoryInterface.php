<?php
namespace App\Core\SubTask\Repository;

use App\Models\SubTask;
use App\Models\Task;

interface SubTaskRepositoryInterface
{

    public function create(Task $parentTask, Task $subTask);
    public function findAllByParentTask(Task $task);
    public function detachSubTask(SubTask $subTask);
    public function findBySubTaskId(int $id) : ?SubTask;
}
