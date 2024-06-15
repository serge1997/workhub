<?php
namespace App\Core\Task;

use App\core\Annex\AnnexRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(
        protected AnnexRepositoryInterface $annexRepositoryInterface
    ){}

    public function create($request)
    {
        $values = $request->all();
        $task = new Task($values);
        $task->manager_id = $request->user()->id;
        $task->save();
        $this->annexRepositoryInterface->create($request, $task);
    }
    public function listAll()
    {

    }

    public function update($request)
    {

    }
}
