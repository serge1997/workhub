<?php
namespace App\Core\Task\Actions;

use App\Models\Task;
use App\Http\Resources\TaskResource;

final class FindTaskAction
{
    public static function run($request) : Task
    {
        return Task::findOrFail($request->task_id);
    }
}
