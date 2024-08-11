<?php
namespace App\Core\TaskActivity;

use App\Models\TaskActivity;

interface TaskActivityRepositoryInterface
{
    public function create(int $author_id, int $task_id, string $content, ?string $description) : TaskActivity;
    public function listByTask();
}
