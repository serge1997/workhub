<?php

namespace App\Http\Controllers;

use App\Core\Task\TaskRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use Exception;

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
            $message = "Tarefa salvou com successo";
            $this->taskRepositoryInterface->create($request);
            return response()
                ->json($message);
        }catch(Exception $e) {
            return response($e->getMessage(), 500);
        }
    }
}
