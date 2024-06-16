<?php
namespace App\Core\Task;

use App\core\Annex\AnnexRepositoryInterface;
use App\Core\Follower\FollowerRepositoryInterface;
use App\Core\TaskRoadMap\TaskRoadMapRepositoryInterface;
use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(
        protected AnnexRepositoryInterface $annexRepositoryInterface,
        protected FollowerRepositoryInterface $followerRepositoryInterface,
        protected TaskRoadMapRepositoryInterface $taskRoadMapRepositoryInterface
    ){}

    public function create($request)
    {
        $values = $request->all();
        $task = new Task($values);
        $task->manager_id = $request->user()->id;
        $task->save();
        $this->annexRepositoryInterface->create($request, $task);
        $this->followerRepositoryInterface->create($request, $task);
        $this->taskRoadMapRepositoryInterface->create($request, $task);
    }
    public function listAll()
    {
        return TaskResource::collection(Task::all());
    }

    public function update($request)
    {

    }
}
