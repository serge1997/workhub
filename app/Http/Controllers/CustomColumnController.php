<?php

namespace App\Http\Controllers;

use App\Core\CustomColumn\CustomColumnRepositoryInterface;
use App\Http\Requests\CustomColumnRequest;
use Exception;
use Illuminate\Http\Request;

class CustomColumnController extends Controller
{
    public function __construct(
        private CustomColumnRepositoryInterface $customColumnRepositoryInterface
    )
    {}

    public function onCreate(CustomColumnRequest $request)
    {
        try{
            $message = "Campo personnlizado criado com successo";
            $this->customColumnRepositoryInterface->create($request);
            return response()
                ->json($message);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function onListAll()
    {
        try{
            return response()
                ->json($this->customColumnRepositoryInterface->listAll());
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
