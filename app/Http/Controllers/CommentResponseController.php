<?php

namespace App\Http\Controllers;

use App\Core\CommentResponse\CommentResponseRepositoryInterface;
use App\Core\Task\Actions\FindTaskAction;
use App\Http\Requests\CommentResponseRequest;
use App\Models\Task;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Core\Task\TaskRepositoryInterface;

class CommentResponseController extends Controller
{
    public function __construct(
        private TaskRepositoryInterface $taskRepositoryInterface,
        private CommentResponseRepositoryInterface $commentResponseRepositoryInterface
    ){}

    public function onCreate(CommentResponseRequest $request) : JsonResponse
    {
        //dd($request->task());die;
        //dd($this->taskRepositoryInterface->find($request->task_id));

        try{

            $message = "Resposta adicionada";
            $action = $this->commentResponseRepositoryInterface->create($request);
            return response()
                ->json([
                    "message" => $message,
                    "data" => $action
                ]);
        }catch(Exception $e){
            return response()
                ->json($e->getFile(). " ". $e->getMessage(), 500);
        }
    }
}
