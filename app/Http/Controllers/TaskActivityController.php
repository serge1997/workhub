<?php

namespace App\Http\Controllers;

use App\Core\TaskActivity\TaskActivityRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class TaskActivityController extends Controller
{
    public function __construct(
        private readonly TaskActivityRepositoryInterface $taskActivityRepositoryInterface
    )
    {

    }

    public function onNotifyByTaskExecutor(Request $request)
    {
        try{
            return response()
                ->json($this->taskActivityRepositoryInterface
                    ->notifyByTaskExecutor($request));
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 422);
        }
    }

    public function onMarkAsReaded(Request $request)
    {
        try{
            $this->taskActivityRepositoryInterface->markAsReaded($request);
        }catch(Exception $e){
            return response()->json($e->getMessage(), 404);
        }
    }
}
