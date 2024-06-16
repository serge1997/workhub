<?php
namespace App\Core\Follower;

use App\Models\Task;
interface FollowerRepositoryInterface
{
    public function create($request, Task $task);
    public function find($request);
    public function update($request);
    public function delete($request);
}
