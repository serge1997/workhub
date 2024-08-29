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

}
