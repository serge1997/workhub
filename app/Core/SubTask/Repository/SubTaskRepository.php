<?php
namespace App\Core\SubTask\Repository;

use App\Models\SubTask;
use App\Models\Task;

class SubTaskRepository implements SubTaskRepositoryInterface
{

    public function create(Task $parentTask,Task $subTask)
    {
        return $parentTask->subTasks()->create([
            'sub_task_id' => $subTask->id
        ]);
    }

    public function findAllByParentTask(Task $task)
    {
        $sub_task_ids = SubTask::where('task_id', $task->id)
            ->pluck('sub_task_id')->all();

        return Task::whereIn('id', $sub_task_ids)
            ->get();
    }
    public function detachSubTask(SubTask $subTask)
    {
        $subTask->delete();
        return $subTask;
    }

    public function findBySubTaskId(int $id) : ?SubTask
    {
        return SubTask::where('sub_task_id', $id)->first();
    }
}
