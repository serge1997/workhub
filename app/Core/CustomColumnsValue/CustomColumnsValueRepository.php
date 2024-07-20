<?php
namespace App\Core\CustomColumnsValue;

use App\Core\CustomColumn\CustomColumnRepositoryInterface;
use App\Models\Task;
use App\Core\CustomColumnsValue\Actions\CreateCustomsColumnsValueAction;
use App\Models\CustomColumnsValue;
use Exception;

class CustomColumnsValueRepository implements CustomColumnsValueRepositoryInterface
{
    public function __construct(
        private CustomColumnRepositoryInterface $customColumnRepositoryInterface
    ){}

    public function create(Task $task, $request)
    {
        (new CreateCustomsColumnsValueAction(
            $task,
            $request,
            $this->customColumnRepositoryInterface,
            $this->findByColumnAndTask($request)
        ))->handle();

    }

    public function beforeSave(CustomColumnsValue $custom)
    {

    }

    public function listAll($request)
    {

    }

    public function findByColumnAndTask($request) : ?CustomColumnsValue
    {
        if ($request->filled('custom_column_id')){
            return CustomColumnsValue::where([
                ['task_id', $request->task_id],
                ['custom_column_id', $request->custom_column_id]
            ])->first();
        }
        return null;
    }
}
