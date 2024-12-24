<?php

namespace App\Http\Controllers;

use App\Core\Annex\Actions\AnnexDeleteAction;
use App\core\Annex\AnnexRepositoryInterface;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Container\ContainerInterface;

class AnnexController extends Controller
{
    use HttpResponse;
    public function __construct(
        private AnnexRepositoryInterface $annexRepositoryInterface,
        private ContainerInterface $container
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

    public function delete($id)
    {
        try{
            /** @var AnnexDeleteAction $annexDeleteAction */
            $annexDeleteAction = $this->container->get(AnnexDeleteAction::class);
            $annexDeleteAction->run($id);
            return response()
                ->json($this->successResponse("Annexo removido com successo"));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse($e->getMessage()));
        }
    }
}
