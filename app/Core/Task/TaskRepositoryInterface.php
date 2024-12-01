<?php
namespace App\Core\Task;

use App\Http\Resources\TaskResource;
interface TaskRepositoryInterface
{
    public function create($request);
    public function listAll();
    public function find($request);
    public function handleExecutionStatus($request);
    public function update($request);
    public function softDelete($request);
    public function listByAuthUser($request);
    public function listTaskByFilteredUser($request);
    public function listBySprint($request);
    public function findAllBySprintAndProject(int $sprint_id, int $project_id);
    public function findInProgressByProjectId(int $project_id);
    public function updatePriority($request);
    public function updateUserId($request);
    public function findAllBacklogTaskByProject(int $project_id);
    public function findAllByProjectAndStatus($project_id, $status);
    public function findAllByIds(array $tasks_ids);
    public function transfertTasks($request);
}
