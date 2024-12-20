<?php
namespace App\Core\Task\Actions;

use App\core\Annex\AnnexRepository;
use App\Core\CustomColumnsValue\CustomColumnsValueRepository;
use App\Core\Follower\FollowerRepository;
use App\Core\TaskActivity\TaskActivityRepository;
use App\Core\TaskRoadMap\TaskRoadMapRepository;
use App\Core\User\UserRepositoryInterface;
use App\Http\Resources\TaskActivityResource;
use App\Services\Servers\WsServer;
use App\Models\Task;

final class CreateTaskAction
{
    public function __construct(
        private AnnexRepository $annexRepository,
        private FollowerRepository $followerRepository,
        private TaskRoadMapRepository $taskRoadMapRepository,
        private CustomColumnsValueRepository $customColumnsValueRepository,
        private TaskActivityRepository $taskActivityRepository,
        private UserRepositoryInterface $userRepository
    )
    {}
    public function run($request)
    {
        $values = $request->all();
        //$ws = new WsServer("ws://localhost:8155/teste");
        $task = new Task($values);
        $task->manager_id = $request->user()->id;
        $task->user_id = $request->user_id;
        $task->sprint_id = $request->sprint_id;
        $user = $this->userRepository->find($request->user_id);
        $task->execution_status_id =  $request->execution_status_id ?? 1;
        $task->team_id = $user?->team_id;
        $task->save();
        $notification_body = $task->user_id ? "Criou uma tarefa para " . $task->user->name : "Criou uma tarefa";
        $this->customColumnsValueRepository->create($task, $request);
        $this->annexRepository->create($request, $task);
        $this->followerRepository->create($request, $task);
        $this->taskRoadMapRepository->create($request, $task);
        $this->taskActivityRepository->create(
            $request->user()->id,
            $task->id,
            $notification_body,
            "Task",
            $task->id
       );
       //websocket called is below
        //$notification->activity = "{$notification->user->name} {$notification->activity}";
        //$ws->notify(new TaskActivityResource($notification));
       return $task;
    }
}
