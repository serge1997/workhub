<?php

namespace App\Http\Controllers;

use App\Core\Task\TaskRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use Exception;
use Illuminate\Support\Facades\DB;
class TaskController extends Controller
{
    public function __construct(
        private TaskRepositoryInterface $taskRepositoryInterface
    )
    {}

    public function onCreate(StoreTaskRequest $request)
    {
        $request->validated();
        try{
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
            $message = "Tarefa foi atualizada para proximo nivel";
            $this->taskRepositoryInterface->handleExecutionStatus($request);
            return response()
                ->json($message);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
