<?php
namespace App\Core\CustomColumnsValue\Actions;

use App\Core\CustomColumn\CustomColumnRepositoryInterface;
use App\Models\CustomColumnsValue;
use App\Models\Task;

final class CreateCustomsColumnsValueAction
{
    public function __construct(
        private Task $task,
        private mixed $request,
        private CustomColumnRepositoryInterface $customColumnRepositoryInterface,
        private ?CustomColumnsValue $customColumnsValue,
    )
    {

    }

    public function handle()
    {
        $customColumns = $this->customColumnRepositoryInterface->listAll();

        if ($this->request->filled('custom_column_id') && $this->request->filled('value')){
            $this->customColumnsValue->update([
                'value' => $this->request->value
            ]);
        }else{
            if ($this->hasTask()){
                foreach ($customColumns as $column) {
                    CustomColumnsValue::query()->create([
                        'task_id' => $this->task->id,
                        'custom_column_id' => $column->id
                    ]);
                }
            }
        }

    }

    private function hasTask() : bool
    {
        return CustomColumnsValue::where('task_id', $this->task->id)->doesntExist();
    }
}
