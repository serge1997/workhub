<?php
namespace App\Core\TaskActivity;

use App\Models\TaskActivity;

class TaskActivityRepository implements TaskActivityRepositoryInterface
{
    public function create(int $author_id, int $task_id, string $content, ?string $description) : void
    {
        TaskActivity::query()->create([
            'description' => $description,
            'user_id' => $author_id,
            'task_id' => $task_id,
            'activity' => $content,
        ]);
    }

    public function listByTask()
    {

    }
}
