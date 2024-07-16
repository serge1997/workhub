<?php
namespace App\Core\CustomColumnsValue;

use App\Models\CustomColumnsValue;
use App\Models\Task;

interface CustomColumnsValueRepositoryInterface
{
    public function create(Task $task, $request);
    public function beforeSave(CustomColumnsValue $custom);
    public function listAll($request);
}
