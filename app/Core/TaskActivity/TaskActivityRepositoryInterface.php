<?php
namespace App\Core\TaskActivity;

use App\Models\TaskActivity;

interface TaskActivityRepositoryInterface
{
    public function create(int $author_id, int $task_id, string $content, ?string $description, ?int $origin_id = null) : TaskActivity;
    public function listByTask(int $id);
    public function notifyByTaskExecutor($request);
    public function markAsReaded($request) : void;
}
