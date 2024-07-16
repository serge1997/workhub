<?php
namespace App\Core\CustomColumnsValue\Actions;
use App\Models\CustomColumnsValue;
use App\Models\Task;

final class CreateCustomsColumnsValueAction
{
    public function __construct(
        private Task $task,
        private mixed $request
    )
    {

    }

    public function handle()
    {
        return CustomColumnsValue::query()->create([
            'task_id' => $this->task->id,
            'custom_column_id' => $this->request->custom_column_id,
            'value' => $this->request->value
        ]);
    }
}
