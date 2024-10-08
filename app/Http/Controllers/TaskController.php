<?php

namespace App\Http\Controllers;

use App\Core\Task\TaskRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use WebSocket\Client;
class TaskController extends Controller
{
    public function __construct(
        private TaskRepositoryInterface $taskRepositoryInterface
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
            return response()
                ->json($this->taskRepositoryInterface->find($request));
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
                ->json($e->getMessage(), 404);
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
}
