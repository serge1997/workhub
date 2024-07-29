<?php
namespace App\Core\TaskActivity;


interface TaskActivityRepositoryInterface
{
    public function create(int $author_id, int $task_id, string $content, ?string $description) : void;
    public function listByTask();
}
