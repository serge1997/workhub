<?php

namespace App\Http\Controllers;

use App\Core\CustomColumnsValue\CustomColumnsValueRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class CustomColumnsValueController extends Controller
{
    public function __construct(
        private CustomColumnsValueRepositoryInterface $customColumnsValueRepositoryInterface
    )
    { }

    public function onFindByTask(Request $request)
    {
        try{
            return response()
                ->json($this->customColumnsValueRepositoryInterface->findByTask($request));
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
