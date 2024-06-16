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
            return response()
                ->json($message);
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }
}
