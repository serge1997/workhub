<?php
namespace App\Core\Task;

use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function create($request)
    {
        $value = $request->all();
        $task = new Task();
    }
    public function listAll()
    {

    }

    public function update($request)
    {

    }
}
