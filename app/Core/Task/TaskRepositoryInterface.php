<?php
namespace App\Core\Task;

use App\Http\Resources\TaskResource;
interface TaskRepositoryInterface
{
    public function create($request);
    public function listAll();
    public function find($request);
    public function inProgress($request);
    public function update($request);

}
