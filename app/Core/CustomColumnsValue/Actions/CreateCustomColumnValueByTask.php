<?php
namespace App\Core\CustomColumnsValue\Actions;

use App\Models\CustomColumnsValue;
use App\Services\Base\BaseAction;

final class CreateCustomColumnValueByTask extends BaseAction
{

    public function run(mixed $request)
    {
        foreach ($request->columns as $column){
            CustomColumnsValue::query()->create([
                'task_id' => $request->task_id,
                'custom_column_id' => $column
            ]);
            $this->logActivity(
                $request->user()->id,
                $request->task_id,
                " adicionou uma nova coluna personnlizado",
                'custom column value'
            );
        }
    }
}
