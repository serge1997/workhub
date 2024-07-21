<?php
namespace App\Core\CustomColumnsValue\Actions;

use App\Models\CustomColumnsValue;

final class CreateCustomColumnValueByTask
{

    public static function run(mixed $request)
    {
        foreach ($request->columns as $column){
            CustomColumnsValue::query()->create([
                'task_id' => $request->task_id,
                'custom_column_id' => $column
            ]);
        }
    }
}
