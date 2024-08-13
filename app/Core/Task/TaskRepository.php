<?php
namespace App\Core\Task;

use App\core\Annex\AnnexRepositoryInterface;
use App\Core\CustomColumnsValue\CustomColumnsValueRepositoryInterface;
use App\Core\Follower\FollowerRepositoryInterface;
use App\Core\Task\Actions\FindTaskAction;
use App\Core\Task\Actions\ExecutionStatusUpdateAction;
use App\Core\Task\Actions\ListTaskByUserAction;
use App\Core\Task\Actions\SoftDeleteTaskAction;
use App\Core\TaskActivity\TaskActivityRepositoryInterface;
use App\Core\TaskRoadMap\TaskRoadMapRepositoryInterface;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\Servers\WsServer;
use App\Core\Task\Actions\CreateTaskAction;

class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(
        protected AnnexRepositoryInterface $annexRepositoryInterface,
        protected FollowerRepositoryInterface $followerRepositoryInterface,
        protected TaskRoadMapRepositoryInterface $taskRoadMapRepositoryInterface,
        protected CustomColumnsValueRepositoryInterface $customColumnsValueRepositoryInterface,
        protected TaskActivityRepositoryInterface $taskActivityRepositoryInterface
    ){}

    public function create($request)
    {
        $action = new CreateTaskAction(
            $this->annexRepositoryInterface,
            $this->followerRepositoryInterface,
            $this->taskRoadMapRepositoryInterface,
            $this->customColumnsValueRepositoryInterface,
            $this->taskActivityRepositoryInterface
        );
        $action->run($request);
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
        (new ExecutionStatusUpdateAction(
            FindTaskAction::run($request),
            $request,
            $this->taskActivityRepositoryInterface,
            )
        )->handle();
    }

    public function update($request)
    {

    }

    public function softDelete($request)
    {
        (new SoftDeleteTaskAction(FindTaskAction::run($request), $request))
            ->handle();
    }

    public function listByUser($request)
    {
        return TaskResource::collection(
            ListTaskByUserAction::list($request)
        );
    }
}
