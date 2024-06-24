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
                ->json($message);
        }catch(Exception $e){
            return response()
                ->json("ddd", 422);
        }
    }
}
