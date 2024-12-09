<?php

namespace App\Http\Controllers;

use App\Core\SubTask\Actions\SubTaskCreateAction;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerInterface;

class SubTaskController extends Controller
{
    use HttpResponse;

    public function __construct(
        private ContainerInterface $container
    ){}

    public function index()
    {

    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            /** @var SubTaskCreateAction $subTaskCreateAction */
            $subTaskCreateAction = $this->container->get(SubTaskCreateAction::class);
            $response = $subTaskCreateAction->run($request);
            DB::commit();
            return response()
                ->json($this->successResponse("sub tarefa salvou com successo", $response));
        }catch(Exception $e){
            DB::rollBack();
            return response()
                ->json($this->errorResponse("Error: {$e->getLine()}"), 500);
        }
    }
}
