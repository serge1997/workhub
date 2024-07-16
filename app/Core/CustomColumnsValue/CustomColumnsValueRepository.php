<?php
namespace App\Core\CustomColumnsValue;

use App\Models\Task;
use App\Core\CustomColumnsValue\Actions\CreateCustomsColumnsValueAction;
use App\Models\CustomColumnsValue;
use Exception;

class CustomColumnsValueRepository implements CustomColumnsValueRepositoryInterface
{
    public function create(Task $task, $request)
    {
        $customValue = (new CreateCustomsColumnsValueAction($task, $request))
                            ->handle();
        if (!CustomColumnsValue::find($customValue->id)->exists()){
            throw new Exception("Error ao inserir custmizado");
        }

    }

    public function beforeSave(CustomColumnsValue $custom)
    {

    }

    public function listAll($request)
    {

    }
}
