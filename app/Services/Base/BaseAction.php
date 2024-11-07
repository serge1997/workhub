<?php
namespace App\Services\Base;

use App\Models\TaskActivity;

abstract class BaseAction
{

    public function logActivity(int $author_id, int $task_id, string $content, ?string $description, ?int $origin_id = null)
    {
        return TaskActivity::create([
                'description' => $description,
                'user_id' => $author_id,
                'task_id' => $task_id,
                'activity' => $content,
                'origin_id' => $origin_id
            ]);
    }
}
