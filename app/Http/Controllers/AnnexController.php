<?php

namespace App\Http\Controllers;

use App\core\Annex\AnnexRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnnexController extends Controller
{
    public function __construct(
        private AnnexRepositoryInterface $annexRepositoryInterface
    )
    {}

    public function onCreate(Request $request) : JsonResponse
    {
        try{
            $message = "Anexo adicionado com sucesso";
            $this->annexRepositoryInterface->create($request);
            return response()
                ->json($message);
        }catch(\Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
