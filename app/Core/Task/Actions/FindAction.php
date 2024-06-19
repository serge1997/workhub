<?php
namespace App\Core\Task\Actions;

use App\Models\Task;
use App\Http\Resources\TaskResource;

final class FindAction
{
    public static function run($request) : Task
    {
        return Task::findOrfail($request->id);
    }
}
