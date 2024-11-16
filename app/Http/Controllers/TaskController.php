<?php

namespace App\Http\Controllers;

use App\Core\Task\Actions\TaskListAction;
use App\Core\Task\TaskRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerInterface;
use WebSocket\Client;
class TaskController extends Controller
{
    use HttpResponse;

    public function __construct(
        private TaskRepositoryInterface $taskRepositoryInterface,
        private ContainerInterface $container
    )
    {}

    public function onCreate(StoreTaskRequest $request)
    {
        try{
            $request->validated();
            DB::beginTransaction();
            $message = "Tarefa salvou com successo";
            $this->taskRepositoryInterface->create($request);
            DB::commit();
            return response()
                ->json($message);
        }catch(Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }

    public function onListAll()
    {
        try{
            return response()
                ->json($this->taskRepositoryInterface->listAll());
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(). " ". $e->getLine(), 500);
        }
    }

    public function onFind(Request $request)
    {
        try{
            $response = new TaskResource(
                $this->taskRepositoryInterface->find($request)
            );
            return response()->json($response);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 402);
        }
    }

    public function onHandleExecutionStatus(Request $request)
    {
        try{
            $message = "O status da tarefa foi atualizado com successo";
            $this->taskRepositoryInterface->handleExecutionStatus($request);
            return response()
                ->json($message);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function onSoftDelete(Request $request)
    {
        try{
            $message = "Tarefa deletado com successo";
            $this->taskRepositoryInterface->softDelete($request);
            return response()
                ->json($message);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function onListByAuthUser(Request $request)
    {
        try{
            return response()
                ->json($this->taskRepositoryInterface->listByAuthUser($request));
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 404);
        }
    }

    public function onListByFilteredUser(Request $request)
    {
        try{
            return response()
                ->json($this->taskRepositoryInterface->listTaskByFilteredUser($request));
        }catch(Exception $e){
            return response()
                ->json($e->getMessage() . $e->getFile() . $e->getLine(), 404);
        }
    }

    public function onListBySprint(Request $request)
    {
        try{
            return response()
                ->json($this->taskRepositoryInterface->listBySprint($request));
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 404);
        }
    }

    public function getByProject(int $project_id)
    {
        try{
            $message = 'lista de tarefas por projetos';
            $response = $this->taskRepositoryInterface->findInProgressByProjectId($project_id);
            return response()
                ->json($this->successResponse($message, $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }

    public function updatePriority(Request $request)
    {
        try{
            $response = $this->taskRepositoryInterface->updatePriority($request);
            return response()
                ->json($this->successResponse('prioridade actualizada com sucesso', $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }

    public function updateUser(Request $request)
    {
        try{
            $action = $this->taskRepositoryInterface->updateUserId($request);
            $response = new TaskResource($action);
            return response()
                ->json($this->successResponse('responsavel atualizado com sucesso', $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }
    public function getAllBySprintAndProject(int $sprint_id, int $project_id)
    {
        try{
            /** @var TaskListAction $taskListAction */
            $taskListAction = $this->container->get(TaskListAction::class);
            $response = $taskListAction->listAllBySprintAndProject($sprint_id, $project_id);
            return response()
                ->json($this->successResponse("lista das tarefas pro sprint e projeto", $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }
}
