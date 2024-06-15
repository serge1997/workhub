<?php
namespace App\Core\Task;

interface TaskRepositoryInterface
{
    public function create($request);
    public function listAll();
    public function update($request);

}
