<?php
namespace App\Core\TaskRoadMap;

use App\Models\Task;

interface TaskRoadMapRepositoryInterface
{
    public function create($request, Task $task);
    public function find($request);
}
