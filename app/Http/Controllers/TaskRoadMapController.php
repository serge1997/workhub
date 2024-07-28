<?php

namespace App\Http\Controllers;

use App\Core\TaskRoadMap\TaskRoadMapRepositoryInterface;
use App\Http\Requests\StoreRoadMapRequest;
use Exception;
use Illuminate\Http\Request;

class TaskRoadMapController extends Controller
{
    public function __construct(
        private TaskRoadMapRepositoryInterface $taskRoadMapRepositoryInterface
    )
    {}

    public function onCreate(StoreRoadMapRequest $request)
    {
        try{
            $message = "Road map adicionada com successo";
            $this->taskRoadMapRepositoryInterface->create($request);
            return response()
                ->json($message);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
