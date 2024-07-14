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
                ->json($e->getMessage(), 422);
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

    public function onFind(Request $request)
    {
        try{
            return response()
                ->json($this->commentRepositoryInterface->find($request));
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function onSoftDelete(Request $request)
    {
        try{
            $message = "Adionado na lixeira";
            $this->commentRepositoryInterface->softDelete($request);
            return response()
                ->json([
                    "message" => $message,
                    "data" => $this->commentRepositoryInterface->listAllByTask($request)
                ]);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 403);
        }
    }

    public function onUpdate(Request $request)
    {
        try{
            $message = "Commentario editado com successo";
            $this->commentRepositoryInterface->update($request);
            return response()
                ->json([
                    "message" => $message,
                    "data" => $this->commentRepositoryInterface->listAllByTask($request)
                ]);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function onListAllSoftDeleted(Request $request)
    {
        try{
            return response()
                ->json($this->commentRepositoryInterface->listAllSoftDeleted($request));
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function onRefreshSoftDelete(Request $request)
    {
        try{
            $message = "Commentario restaurado com successo";
            $this->commentRepositoryInterface->refreshSodftDelete($request);
            return response()
                ->json($message);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
