<?php

namespace App\Http\Controllers;

use App\Core\TaskExecutionStatus\Actions\TaskExceutionStatusListAction;
use App\Core\TaskExecutionStatus\TaskExecutionStatusRepositoryInterface;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;
use Psr\Container\ContainerInterface;

class TaskExecutionStatusController extends Controller
{
    use HttpResponse;
    public function __construct(
        private readonly TaskExecutionStatusRepositoryInterface $taskExecutionStatusRepositoryInterface,
        private readonly ContainerInterface $container
    )
    {}

    public function onListall()
    {
        try{
            return response()
                ->json($this->taskExecutionStatusRepositoryInterface->listAll());
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function listByProjectWithTaskCount(int $project_id)
    {
        try{
            /** @var TaskExceutionStatusListAction $taskExecutionListAction */
            $taskExecutionListAction = $this->container->get(TaskExceutionStatusListAction::class);
            $response = $taskExecutionListAction->listAllWithTaskCountByProject($project_id);
            return response()
                ->json($this->successResponse("lista de status e tarefas por projeto", $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse($e->getMessage(), 404));
        }
    }

    public function listCountBySprint(int $sprint_id)
    {
        try{
            /** @var TaskExceutionStatusListAction $taskExecutionListAction */
            $taskExecutionListAction = $this->container->get(TaskExceutionStatusListAction::class);
            $response = $taskExecutionListAction->listAllCountBySprint($sprint_id);
            return response()
                ->json($this->successResponse("lista de status e quatidade de tarefas", $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse($e->getMessage(), 404));
        }
    }
}
