<?php

namespace App\Http\Controllers;

use App\Core\Comment\CommentRepositoryInterface;
use App\Http\Requests\CommentRequest;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(
        private CommentRepositoryInterface $commentRepositoryInterface
    )
    {}

    public function onCreate(CommentRequest $request)
    {
        try{
            $message = "Commentario adicionado";
            $this->commentRepositoryInterface->create($request);
            return response()
                ->json([
                    "message" => $message,
                    "data" => $this->commentRepositoryInterface->listAllByTask($request)
                ]);
        }catch(Exception $e){
            return response()
                ->json("ddd", 422);
        }
    }

    public function onListAllByTask(Request $request)
    {
        try{
            return response()
                ->json($this->commentRepositoryInterface->listAllByTask($request));
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
