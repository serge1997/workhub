<?php
namespace App\Core\CustomColumnsValue;

use App\Models\CustomColumnsValue;
use App\Core\CustomColumn\CustomColumnRepositoryInterface;
use App\Models\Task;

interface CustomColumnsValueRepositoryInterface
{
    public function create(Task $task, $request);
    public function beforeSave(CustomColumnsValue $custom);
    public function listAll($request);
    public function findByColumnAndTask($request) : ?CustomColumnsValue;
    public function findByTask($request);
    public function update($request);
}
