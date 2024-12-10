<?php

namespace App\Http\Controllers;

use App\Core\SubTask\Actions\SubTaskCreateAction;
use App\Core\SubTask\Actions\SubTaskDeleteAction;
use App\Core\SubTask\Actions\SubTaskListAction;
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
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }

    public function listByParent(Request $request)
    {
        try{
            /** @var SubTaskListAction $subTaskListAction */
            $subTaskListAction = $this->container->get(SubTaskListAction::class);
            $response = $subTaskListAction->listAllByParent($request);
            return response()
                ->json($this->successResponse("list de sub tarefas por tarefa pai", $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }

    public function detach(int $id)
    {
        try{
            /** @var SubTaskDeleteAction $subTaskDeleteAction */
            $subTaskDeleteAction = $this->container->get(SubTaskDeleteAction::class);
            $response = $subTaskDeleteAction->detach($id);
            return response()
                ->json($this->successResponse("relação deletada com sucesso", $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }
}
