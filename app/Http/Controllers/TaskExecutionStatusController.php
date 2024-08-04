<?php

namespace App\Http\Controllers;

use App\Core\TaskExecutionStatus\TaskExecutionStatusRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class TaskExecutionStatusController extends Controller
{
    public function __construct(
        private readonly TaskExecutionStatusRepositoryInterface $taskExecutionStatusRepositoryInterface
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
}
