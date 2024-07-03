<?php
namespace App\Core\Task;

use App\core\Annex\AnnexRepositoryInterface;
use App\Core\Follower\FollowerRepositoryInterface;
use App\Core\Task\Actions\FindTaskAction;
use App\Core\Task\Actions\ExecutionStatusUpdateAction;
use App\Core\TaskRoadMap\TaskRoadMapRepositoryInterface;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Notifications\TaskAddedNotification;
use Illuminate\Support\Facades\Notification;

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
        Notification::send($request->user(), new TaskAddedNotification($request->user(), $task));
    }
    public function listAll()
    {
        return TaskResource::collection(Task::orderBy('created_at', 'desc')->get());
    }

    public function find($request)
    {
        return new TaskResource(FindTaskAction::run($request));
    }

    public function handleExecutionStatus($request)
    {
        (new ExecutionStatusUpdateAction(FindTaskAction::run($request)))
            ->handle();
    }

    public function update($request)
    {

    }
}
