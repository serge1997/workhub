<?php
namespace App\Core\CustomColumnsValue;

use App\Core\CustomColumn\CustomColumnRepositoryInterface;
use App\Core\CustomColumnsValue\Actions\CreateCustomColumnValueByTask;
use App\Models\Task;
use App\Core\CustomColumnsValue\Actions\CreateCustomsColumnsValueAction;
use App\Core\CustomColumnsValue\Actions\UpdateCustomColumnsValueAction;
use App\Core\Task\TaskRepository;
use App\Core\Task\TaskRepositoryInterface;
use App\Http\Resources\CustomsColumnsValueResource;
use App\Models\CustomColumnsValue;
use Exception;

class CustomColumnsValueRepository implements CustomColumnsValueRepositoryInterface
{
    public function __construct(
        protected CustomColumnRepositoryInterface $customColumnRepositoryInterface,
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

    public function findByTask($request)
    {
        return CustomsColumnsValueResource::collection(
            CustomColumnsValue::where('task_id', $request->task_id)
            ->get()
        );
    }

    public function update($request)
    {
        (new UpdateCustomColumnsValueAction(
            $this->findByColumnAndTask($request),
            $request)
        )->handle();
        $task = app()->make(TaskRepository::class);
        return $task->find($request);
    }

    public function createByTask($request)
    {
        app(CreateCustomColumnValueByTask::class)->run($request);
    }
}
