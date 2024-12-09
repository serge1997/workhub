<?php
namespace App\Core\SubTask\Repository;

use App\Models\Task;

interface SubTaskRepositoryInterface
{

    public function create(Task $parentTask, Task $subTask);
}
