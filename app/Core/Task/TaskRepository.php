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
use App\Core\Task\Actions\ListTaskByFilteredUserAction;
use App\Core\Task\Actions\TaskListAction;
use App\Core\Task\Actions\TaskUpdateAction;
use App\Models\TaskExecutionStatus;

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
        return Task::find($request->task_id);
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

    public function listByAuthUser($request)
    {
        return TaskResource::collection(
            ListTaskByUserAction::list($request)
        );
    }

    public function listTaskByFilteredUser($request)
    {
        return TaskResource::collection(
            ListTaskByFilteredUserAction::list($request)
        );
    }

    public function listBySprint($request)
    {
        return TaskResource::collection(
            Task::where([['sprint_id', $request->sprint_id], ['execution_status_id','<>', TaskExecutionStatus::BACKLOG]])
                ->orderBy('created_at', 'desc')
                    ->get()
        );
    }

    public function findInProgressByProjectId(int $project_id)
    {
        /** @var TaskListAction $action */
        $action = app(TaskListAction::class);
        return TaskResource::collection(
            $action->listByProject($project_id)
        );
    }
    public function updatePriority($request)
    {
        /** @var TaskUpdateAction $taskUpdate */
        $taskUpdate = app(TaskUpdateAction::class);
        $data = $taskUpdate->priority($this->find($request), $request);
        return $data;
    }

    public function updateUserId($request)
    {
        /** @var TaskUpdateAction $taskUpdate */
        $taskUpdate = app(TaskUpdateAction::class);
        $data = $taskUpdate->updateUserId($this->find($request), $request);
        return $data;
    }
    public function findAllBySprintAndProject(int $sprint_id, int $project_id)
    {
        return Task::where([['sprint_id', $sprint_id], ['project_id', $project_id]])
            ->orderBy('created_at', 'desc')
                ->get();
    }
    public function findAllBacklogTaskByProject(int $project_id)
    {
        return Task::where([['project_id', $project_id], ['execution_status_id', TaskExecutionStatus::BACKLOG]])
            ->orderBy('created_at', 'desc')
                ->get();
    }
}
