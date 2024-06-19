<?php
namespace App\Core\Task\Actions;

use App\Models\Task;

final class InProgressAction
{

    public static function run($request)
    {
        $task = FindAction::run($request);
        $task->update([
            'execution_status' => Task::IN_PROGRESS
        ]);
    }
}
