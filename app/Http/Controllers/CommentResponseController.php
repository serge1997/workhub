<?php

namespace App\Http\Controllers;

use App\Core\CommentResponse\CommentResponseRepositoryInterface;
use App\Http\Requests\CommentResponseRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentResponseController extends Controller
{
    public function __construct(
        private CommentResponseRepositoryInterface $commentResponseRepositoryInterface
    ){}

    public function onCreate(CommentResponseRequest $request) : JsonResponse
    {
        try{
            $message = "Resposta adicionada";
            $this->commentResponseRepositoryInterface->create($request);
            return response()
                ->json($message);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
